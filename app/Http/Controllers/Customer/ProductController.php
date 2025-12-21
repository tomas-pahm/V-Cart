<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        // Sản phẩm liên quan cùng danh mục
        $relatedProducts = Product::where('category_id', $product->category_id)
                                  ->where('product_id', '!=', $product->product_id)
                                  ->inRandomOrder()
                                  ->limit(8)
                                  ->get();

        return view('customer.products.detail', compact('product', 'relatedProducts'));
    }
}