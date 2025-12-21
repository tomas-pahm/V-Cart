<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;


class WishlistController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $wishlistProducts = $user->wishlistProducts; // Lấy danh sách sản phẩm yêu thích

    return view('wishlist', compact('wishlistProducts'));
}

public function toggle(Request $request)
{
    $productId = $request->product_id;
    $user = auth()->user();

    $wishlistItem = $user->wishlists()->where('product_id', $productId)->first();

    if($wishlistItem) {
        $wishlistItem->delete();
        $status = 'removed';
    } else {
        $user->wishlists()->create(['product_id' => $productId]);
        $status = 'added';
    }

    return response()->json([
        'status' => $status,
        'count' => $user->wishlists()->count()
    ]);
}

}
