<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;

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

}
