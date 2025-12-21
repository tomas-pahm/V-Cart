<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    // === TỔNG ĐƠN HÀNG HÔM NAY ===
    $todayOrders = Order::whereDate('order_date', Carbon::today())->count();

    // === DOANH THU HÔM NAY ===
    $todayRevenue = Order::whereDate('order_date', Carbon::today())
        ->sum('total_amount');

    // === SỐ SẢN PHẨM ĐANG BÁN ===
    $productsCount = Product::count();

    // === KHÁCH HÀNG MỚI HÔM NAY ===
    $newCustomers = User::whereDate('created_at', Carbon::today())
    ->where('role_id', 1)
    ->count();


    // === SẢN PHẨM SẮP HẾT ===
    $lowStockProducts = Product::where('stock', '<=', 80)
        ->orderBy('stock', 'asc')
        ->take(6)
        ->get();

    $latestOrders = Order::with('user')
    ->latest()
    ->take(5)
    ->get();


    return view('admin.dashboard', compact(
        'todayOrders',
        'todayRevenue',
        'productsCount',
        'newCustomers',
        'lowStockProducts',
        'latestOrders'
    ));
}

}
