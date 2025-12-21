<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class VegetasController extends Controller
{
    // Trang chủ
    public function welcome()
    {
        // Lấy sản phẩm của 3 category: Rau củ, Trái cây, Thực phẩm khô
        $products = Product::whereIn('category_id', [1, 2, 3])->latest()->get();
        return view('welcome', compact('products'));
    }

    // Dashboard (dành cho người đăng nhập)
    public function dashboard()
{
    // === CHẶN CỨNG ADMIN & SUPER ADMIN KHÔNG ĐƯỢC VÀO TRANG CUSTOMER ===
    if (auth()->check() && in_array(auth()->user()->role_id, [2, 3])) {
        return redirect()->route('admin.dashboard');
    }

    // === Chỉ Customer mới được vào đây ===
    $products = Product::whereIn('category_id', [1, 2, 3])->latest()->get();
    return view('dashboard', compact('products'));
}

    public function search(Request $request)
{
    $query = $request->input('query');

    // Tìm sản phẩm theo tên chứa từ khóa
    $products = Product::where('name', 'LIKE', "%{$query}%")
                        ->whereIn('category_id', [1,2,3]) 
                        ->latest()
                        ->get();

    return view('search_results', compact('products', 'query'));
}

}
