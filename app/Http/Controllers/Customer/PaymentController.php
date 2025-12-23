<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order')
            ->whereHas('order', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('customer.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
{
    //Kiểm tra owner
    if ($payment->order->user_id !== auth()->id()) {
        abort(403);
    }

    return view('customer.payments.show', compact('payment'));
}
 
    public function cancel(Payment $payment)
{
    // Kiểm tra bảo mật
    if ($payment->order->user_id !== auth()->id()) {
        abort(403);
    }

    // Chỉ cho phép hủy khi payment đang ở trạng thái Pending
    if ($payment->status !== 'Pending') {
        return back()->with('error', 'Giao dịch này đã hoàn tất hoặc đã bị hủy trước đó.');
    }

    DB::beginTransaction();
    try {
        // 1. Cập nhật trạng thái Payment sang 'Failed' (theo ENUM bạn cung cấp)
        $payment->update([
            'status' => 'Failed'
        ]);

        // 2. Cập nhật trạng thái Order sang 'Cancelled'
        $payment->order->update([
            'order_status' => 'Cancelled'
        ]);

        // 3. Hoàn lại số lượng tồn kho (Stock)
        // Lưu ý: Đảm bảo Model Order đã có relation 'items' trỏ đến OrderDetail
        foreach ($payment->order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        DB::commit();
        return back()->with('success', 'Đã hủy đơn hàng và cập nhật tồn kho.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
    }
}

}
