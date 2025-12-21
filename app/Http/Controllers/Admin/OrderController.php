<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
{
    $query = Order::with('user');

    // Lọc mã đơn
    if ($request->filled('order_id')) {
        $query->where('order_id', $request->order_id);
    }

    // Lọc tên khách hàng
    if ($request->filled('customer')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->customer . '%');
        });
    }

    // Lọc trạng thái
    if ($request->filled('status')) {
        $query->where('order_status', $request->status);
    }

    // Lọc theo preset ngày
if ($request->filled('date')) {
    switch ($request->date) {
        case 'today':
            $query->whereDate('created_at', Carbon::today());
            break;

        case 'week':
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
            break;

        case 'month':
            $query->whereMonth('created_at', Carbon::now()->month);
            break;

        case 'custom':
            // để phần FROM – TO xử lý
            break;
    }
}

// FROM – TO (chỉ áp dụng khi có giá trị)
if ($request->filled('from')) {
    $query->whereDate('created_at', '>=', $request->from);
}

if ($request->filled('to')) {
    $query->whereDate('created_at', '<=', $request->to);
}


    $orders = $query->orderBy('order_id', 'DESC')
                    ->paginate(10)
                    ->withQueryString();

    return view('admin.orders.index', compact('orders'));
}



    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function approve(Order $order)
{
    if ($order->order_status !== 'confirmed') {
        $order->order_status = 'confirmed';
        $order->save();
    }

    return redirect()->back()->with('success', 'Đơn hàng đã được duyệt.');
}


    
}
