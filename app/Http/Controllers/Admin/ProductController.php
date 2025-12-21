<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
    use Carbon\Carbon;

class ProductController extends Controller
{

public function index(Request $request)
{
    $query = Product::with('category');

    // Tìm kiếm theo tên
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Lọc theo danh mục
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Lọc theo tồn kho
    if ($request->filled('stock')) {
        if ($request->stock === 'in_stock') {
            $query->where('stock', '>', 0);
        } elseif ($request->stock === 'low_stock') {
            $query->whereBetween('stock', [1, 10]);
        } elseif ($request->stock === 'out_of_stock') {
            $query->where('stock', 0);
        }
    }

    // ⭐ LỌC NGÀY TẠO
    if ($request->filled('date')) {
        if ($request->date === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($request->date === 'week') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($request->date === 'month') {
            $query->where('created_at', '>=', Carbon::now()->startOfMonth());
        } elseif ($request->date === 'custom' && $request->filled(['from','to'])) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }
    }

    $products = $query->orderBy('created_at', 'desc')
                      ->paginate(10)
                      ->withQueryString();

    return view('admin.products.index', compact('products'));
}


    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
{
    // Validate dữ liệu
    $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'category_id' => 'required|exists:category,category_id',
        'stock'       => 'nullable|integer|min:0',
        'description' => 'nullable|string',
        'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:20480'
    ]);

    // Lấy dữ liệu cơ bản
    $data = $request->only(['name', 'price', 'category_id', 'stock', 'description']);

    // Upload ảnh (nếu có)
    if ($request->hasFile('images')) {
        $paths = [];
        $uploadPath = public_path('frontend/images/sanpham');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        foreach ($request->file('images') as $image) {
            $filename = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($uploadPath, $filename);
            $paths[] = $filename;
        }

        $data['images'] = $paths;
    }

    // Lưu sản phẩm
    $product = Product::create($data);

    // Ghi lịch sử tồn kho nếu stock > 0
    if (!empty($data['stock']) && $data['stock'] > 0) {
        StockMovement::create([
    'product_id' => $product->product_id,
    'type'       => 'in', // ← dùng 'in' thay cho 'initial'
    'quantity'   => $data['stock'],
    'old_stock'  => 0,
    'new_stock'  => $data['stock'],
    'reason'     => 'Nhập tồn kho ban đầu',
    'created_by' => auth()->id(),
]);

    }

    return redirect()->route('admin.products.index')
                     ->with('success', 'Thêm sản phẩm thành công!');
}



    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'category_id' => 'required|exists:category,category_id',
        'stock'       => 'nullable|integer|min:0',
        'description' => 'nullable|string',
        'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:20480' // 20 MB

    ]);

    $data = $request->only(['name', 'price', 'category_id', 'stock', 'description']);

    if ($request->hasFile('images')) {
        if ($product->images) {
            foreach ($product->images ?? [] as $old) {
                $oldPath = public_path('frontend/images/sanpham/' . $old);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
        }

        $paths = [];
        foreach ($request->file('images') as $image) {
            $filename = $image->getClientOriginalName();
            $image->move(public_path('frontend/images/sanpham'), $filename);
            $paths[] = $filename;
        }
        $data['images'] = $paths;
    }

    $oldStock = $product->getOriginal('stock'); // ← lấy trước khi update

    $product->update($data); // ← update trước

    $newStock = $product->stock; // ← lấy sau khi update

    // GHI LỊCH SỬ NẾU TỒN KHO THAY ĐỔI
    if ($request->filled('stock') && $newStock != $oldStock) {
        StockMovement::create([
            'product_id' => $product->product_id,
            'type'       => 'adjust',
            'quantity'   => $newStock - $oldStock,
            'old_stock'  => $oldStock,
            'new_stock'  => $newStock,
            'reason'     => 'Điều chỉnh tồn kho thủ công',
            'created_by' => auth()->id(),
        ]);
    }

    return redirect()->route('admin.products.index')
        ->with('success', 'Cập nhật sản phẩm thành công!');
}
    public function destroy(Product $product)
{
    // GHI LẠI LỊCH SỬ TRƯỚC KHI XÓA
    if ($product->stock > 0) {
        StockMovement::create([
            'product_id' => $product->product_id,
            'type'       => 'adjust',
            'quantity'   => -$product->stock,           // âm = giảm tồn
            'old_stock'  => $product->stock,
            'new_stock'  => 0,
            'reason'     => 'Xóa sản phẩm khỏi hệ thống',
            'created_by' => auth()->id(),
        ]);
    }

    // XÓA ẢNH
    if ($product->images) {
        foreach ($product->images ?? [] as $img) {
            @unlink(public_path('frontend/images/sanpham/' . $img));
        }
    }

    $product->delete();

    return back()->with('success', 'Xóa sản phẩm thành công!');
}
}