<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CartHistory;

class CheckoutController extends Controller
{
    public function process(Request $request)
{
    $user = Auth::user();
    $cartItems = CartItem::where('user_id', $user->user_id)->with('product')->get();

    if ($cartItems->count() == 0) {
        return redirect()->back()->with('error', 'Giỏ hàng đang trống!');
    }

    // -----------------------
    // Giả lập thanh toán Online
    // -----------------------
    $paymentMethod = request('method') === 'online' ? 'Online' : 'COD';

    if ($paymentMethod === 'Online') {
        $success = rand(1, 100) <= 70; // 70% thành công

        if (!$success) {
            return redirect()->back()->with('error', 'Thanh toán thất bại! Vui lòng thử lại.');
        }
    }

    DB::beginTransaction();

try {
    $total = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
    $note = $request->input('order_note');

    $order = Order::create([
        'user_id' => $user->user_id,
        'total_amount' => $total,
        'receiver_name' => $user->name,
        'receiver_phone' => $user->phone,
        'shipping_address' => $user->address,
        'note' => $note,
        'payment_method' => $paymentMethod,
        'payment_status' => $paymentMethod === 'Online' ? 'Paid' : 'Unpaid',
        'order_status' => 'Pending',
    ]);

      // ------- Tạo bản ghi Payment -------
$paymentStatus = $request->input('method') === 'online' ? 'Success' : 'Pending';

      Payment::create([
    'order_id' => $order->order_id,
    'amount' => $total,
    'method' => $request->input('method') === 'online' ? 'Online' : 'COD',
    'gateway_transaction_id' => null, 
    'status' => $paymentStatus,
    'paid_at' => $paymentStatus === 'Success' ? now() : null,
    'created_at' => now(),
]);


    foreach ($cartItems as $item) {
        // Tạo order detail
        OrderDetail::create([
            'order_id' => $order->order_id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ]);

        $product = $item->product;
        
        if ($product->stock < $item->quantity) {
            throw new \Exception("Sản phẩm {$product->name} không đủ số lượng trong kho!");
        }
        $product->decrement('stock', $item->quantity);
    }

    // Lưu lịch sử cart
    $historyData = $cartItems->map(fn($item) => [
        'user_id' => $item->user_id,
        'product_id' => $item->product_id,
        'quantity' => $item->quantity,
        'created_at' => now(),
        'updated_at' => now(),
    ])->toArray();

    CartHistory::insert($historyData);

    // Xóa giỏ hàng
    CartItem::where('user_id', $user->user_id)->delete();

    DB::commit();

   return back()->with('success', 'Đặt hàng thành công!');


} catch (\Exception $e) {
    DB::rollBack();
    return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
}

}
}
