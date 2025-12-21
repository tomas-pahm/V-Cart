<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\CartHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Thêm vào giỏ hàng
    public function add(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        if ($request->ajax()) {
            return response()->json(['error' => 'Không tìm thấy sản phẩm'], 404);
        }
        return back()->with('error', 'Không tìm thấy sản phẩm');
    }

    if (Auth::check()) {
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $product->product_id)
                            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'user_id'     => Auth::id(),
                'product_id'  => $product->product_id,
                'quantity'    => 1
            ]);
        }

        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
    } else {
        $cart = session('cart', []);
        $pid = $product->product_id;

        if (isset($cart[$pid])) {
            $cart[$pid]['quantity']++;
        } else {
            $cart[$pid] = [
                'product_id' => $product->product_id,
                'name'       => $product->name,
                'price'      => $product->price,
                'image'      => $product->images[0] ?? 'default.jpg',
                'quantity'   => 1
            ];
        }
        session(['cart' => $cart]);

        $cartCount = collect(session('cart', []))->sum('quantity');
    }

    // Nếu AJAX request trả về JSON
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'cartCount' => $cartCount
        ]);
    }

    return back()->with('success', 'Đã thêm vào giỏ hàng!');
}

        // ================== DÀNH RIÊNG CHO TRANG CHI TIẾT SẢN PHẨM ==================
    // Thêm vào giỏ với số lượng tùy chọn + kiểm tra tồn kho
    public function add2(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại!'], 404);
    }

    if ($product->stock <= 0) {
        return response()->json(['success' => false, 'message' => 'Sản phẩm đã hết hàng!'], 400);
    }

    $quantity = (int) $request->input('quantity', 1);
    if ($quantity < 1) $quantity = 1;
    if ($quantity > $product->stock) {
        return response()->json([
            'success' => false,
            'message' => "Chỉ còn {$product->stock} phần available!",
            'max'     => $product->stock
        ], 400);
    }

    if (Auth::check()) {
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $product->product_id)
                            ->first();

        $newQuantity = $quantity;
        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Trong giỏ đã có {$cartItem->quantity} phần. Chỉ còn {$product->stock} phần available!",
                    'max'     => $product->stock
                ], 400);
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id'     => Auth::id(),
                'product_id'  => $product->product_id,
                'quantity'    => $quantity
            ]);
        }
        $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
    } else {
        $cart = session('cart', []);
        $pid  = $product->product_id;
        $currentQty = $cart[$pid]['quantity'] ?? 0;
        $newQuantity = $currentQty + $quantity;

        if ($newQuantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => "Chỉ còn {$product->stock} phần available!",
                'max'     => $product->stock
            ], 400);
        }

        $cart[$pid] = [
            'product_id' => $product->product_id,
            'name'       => $product->name,
            'price'      => $product->price,
            'image'      => $product->images[0] ?? 'default.jpg',
            'quantity'   => $newQuantity
        ];
        session(['cart' => $cart]);
        $cartCount = collect($cart)->sum('quantity');
    }

    return response()->json([
        'success'   => true,
        'message'   => 'Đã thêm vào giỏ hàng!',
        'cartCount' => $cartCount
    ]);
}


    // Xem giỏ hàng
    public function index()
    {
        if (Auth::check()) {
            $cartItems = Auth::user()
                ->cartItems()
                ->with('product')
                ->get()
                ->filter(fn($item) => $item->product !== null);
        } else {
            $sessionCart = session('cart', []);
            $cartItems = collect();

            foreach ($sessionCart as $item) {
                $product = Product::find($item['product_id'] ?? null);
                if ($product) {
                    $cartItems->push((object)[
                        'cart_item_id' => $item['product_id'], // dùng product_id làm key tạm
                        'product_id'   => $product->product_id,
                        'quantity'     => $item['quantity'] ?? 1,
                        'product'      => $product,
                    ]);
                }
            }
        }

        return view('customer.cart.index', compact('cartItems'));
    }

    // CẬP NHẬT SỐ LƯỢNG
    public function update(Request $request, $id)
    {
        $quantity = (int) $request->quantity;

        if ($quantity < 1) {
            return $this->remove($id); // nếu số lượng = 0 thì xóa luôn
        }

        if (Auth::check()) {
            $cartItem = CartItem::where('cart_item_id', $id)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();
            $cartItem->quantity = $quantity;
            $cartItem->save();
        } else {
            $cart = session('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
                session(['cart' => $cart]);
            }
        }

        return back()->with('success', 'Đã cập nhật số lượng!');
    }

    // XÓA SẢN PHẨM KHỎI GIỎ HÀNG
    public function remove($id)
    {
        if (Auth::check()) {
            CartItem::where('cart_item_id', $id)
                    ->where('user_id', Auth::id())
                    ->delete();
        } else {
            $cart = session('cart', []);
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }


    //LỊCH SỬ MUA HÀNG
    public function history()
{
    $user = Auth::user();
    $historyItems = CartHistory::where('user_id', $user->user_id)
        ->with('product')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('customer.cart.history', compact('historyItems'));
}
}