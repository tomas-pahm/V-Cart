<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Danh sách user
    public function index(Request $request)
{
    $query = User::query();

    // 1. Lọc role (chỉ cho phép Admin thấy Customer & Admin)
    if ($request->filled('role')) {
        if ($request->role == 1) {
            $query->where('role_id', 1);
        }
        if ($request->role == 2) {
            $query->whereIn('role_id', [2, 3]); // Cho phép thấy cả Super Admin khi lọc "Admin"
        }
        if ($request->role == 3) {
            $query->where('role_id', 3);
        }
    }

    // 2. Search
    if ($request->filled('search')) {
        $search = strtolower($request->search);

        $query->where(function($q) use ($search) {
            $q->whereRaw('LOWER(name) LIKE ?', ["%$search%"])
              ->orWhereRaw('LOWER(email) LIKE ?', ["%$search%"]);
        });

        // Nếu là Admin (role_id = 2) và search có chữ "admin" → thêm Super Admin vào kết quả
        if (auth()->user()->role_id == 2 && str_contains($search, 'admin')) {
            $query->orWhere('role_id', 3);
        }
    }

    // 3. Filter ngày (giữ nguyên)
    if ($request->filled('date')) {
        if ($request->date === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($request->date === 'week') {
            $query->whereDate('created_at', '>=', now()->subDays(7));
        } elseif ($request->date === 'month') {
            $query->whereMonth('created_at', now()->month);
            $query->whereYear('created_at', now()->year);
        } elseif ($request->date === 'custom') {
            if ($request->filled('from')) {
                $query->whereDate('created_at', '>=', $request->from);
            }
            if ($request->filled('to')) {
                $query->whereDate('created_at', '<=', $request->to);
            }
        }
    }

    // Lấy dữ liệu + phân trang
    $users = $query->orderBy('user_id', 'desc')
                    ->paginate(10)
                    ->withQueryString();

    // Quan trọng: Ẩn danh tính thật của Super Admin đối với Admin thường
    if (auth()->user()->role_id == 2) {
        $users->getCollection()->transform(function ($user) {
            if ($user->role_id === 3) {
                // Giả lập thành Admin (role_id = 2)
                $user->role_id = 2; // để view dùng đúng logic hiển thị "Admin"
                // Có thể set thêm thuộc tính ảo nếu cần
                $user->display_role = 'Admin';
            }
            return $user;
        });
    }

    return view('admin.users.index', compact('users'));
}


    // Form edit user
    public function edit(User $user)
{
    $roles = [];

    if (auth()->user()->role_id == 3) {
        $roles = Role::all();
    }

    return view('admin.users.edit', compact('user', 'roles'));
}



    // Lưu cập nhật user
    public function update(Request $request, User $user)
{
   

    // 1. Cấm Admin chỉnh Super Admin
    if (auth()->user()->role_id != 3 && $user->role_id == 3) {
        abort(403, 'Bạn không có quyền chỉnh Super Admin');
    }

    // 2. Validate chung
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'email' => 'required|email',
        'password' => 'nullable|min:6',

        // Chỉ validate role_id nếu là super admin
        'role_id' => auth()->user()->role_id == 3
            ? 'required|integer'
            : 'nullable'
    ]);

    // Cấm bất kỳ ai tự đổi role của chính mình
if ($user->user_id == auth()->id() && $request->role_id != $user->role_id) {
    return back()->with('error', 'Bạn không thể thay đổi vai trò của chính mình!');
}


    // 3. Trường dữ liệu mà admin được sửa
    $data = $request->only(['name', 'phone', 'address', 'email']);

    // 4. Nếu là Super Admin → được phép chỉnh role
    if (auth()->user()->role_id == 3) {
        $data['role_id'] = $request->role_id;
    }

    // 5. Password (cả admin và super admin đều sửa được)
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // 6. Thực hiện update
    $user->update($data);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'Cập nhật người dùng thành công');
}



    // Xóa user
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Đã xóa người dùng');
    }
}
