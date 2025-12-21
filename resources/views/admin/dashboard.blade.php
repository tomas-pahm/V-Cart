@extends('layouts.admin')

@section('title', 'Bảng điều khiển quản trị')

@section('content')

{{-- === CHÀO MỪNG === --}}
<div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-600 rounded-xl p-8 mb-10">
    <h3 class="text-2xl font-bold text-green-800">
        Xin chào, {{ auth()->user()->name }}!
    </h3>
    <p class="text-green-700 mt-1 text-base">
        Chúc bạn một ngày làm việc hiệu quả!
    </p>
</div>

{{-- === THỐNG KÊ NHANH === --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 rounded-xl text-white shadow-lg">
        <p class="text-sm text-green-100">Tổng đơn hàng hôm nay</p>
        <p class="text-4xl font-bold mt-1">{{ $todayOrders }}</p>
    </div>

    <div class="bg-gradient-to-br from-amber-500 to-orange-600 p-6 rounded-xl text-white shadow-lg">
        <p class="text-sm text-amber-100">Doanh thu hôm nay</p>
        <p class="text-4xl font-bold mt-1">
            {{ number_format($todayRevenue, 0, ',', '.') }}đ
        </p>
    </div>

    <div class="bg-gradient-to-br from-blue-500 to-cyan-600 p-6 rounded-xl text-white shadow-lg">
        <p class="text-sm text-blue-100">Sản phẩm đang bán</p>
        <p class="text-4xl font-bold mt-1">{{ $productsCount }}</p>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-6 rounded-xl text-white shadow-lg">
        <p class="text-sm text-purple-100">Khách hàng mới hôm nay</p>
        <p class="text-4xl font-bold mt-1">+{{ $newCustomers }}</p>
    </div>

</div>


{{-- === KHUNG LỚN === --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <div class="bg-white p-6 rounded-xl shadow-md border">
    <h3 class="text-xl font-bold text-red-700 mb-4">Sản phẩm sắp hết hàng</h3>

    <div class="space-y-3">
        @forelse ($lowStockProducts as $p)
            <div class="flex justify-between p-3 rounded-lg
                @if($p->stock <= 5) bg-red-50
                @elseif($p->stock <= 10) bg-orange-50
                @else bg-yellow-50 @endif
            ">
                <span class="font-medium">{{ $p->name }}</span>

                <span class="font-bold 
                    @if($p->stock <= 5) text-red-600
                    @elseif($p->stock <= 10) text-orange-600
                    @else text-yellow-700 @endif
                ">
                    Còn {{ $p->stock }}
                </span>
            </div>
        @empty
            <p class="text-gray-500 text-sm">Không có sản phẩm nào sắp hết hàng 🎉</p>
        @endforelse
    </div>
</div>


    {{-- Đơn hàng mới --}}
<div class="bg-white p-6 rounded-xl shadow-md border">
    <h3 class="text-xl font-bold text-blue-700 mb-4">Đơn hàng mới nhất</h3>

    <div class="space-y-3">

        @forelse ($latestOrders as $order)
            <div class="flex justify-between p-3 
                @if($loop->odd) bg-blue-50 @else bg-gray-50 @endif
                rounded-lg">

                <div>
                    <p class="font-medium">
                        #{{ $order->order_id }} - {{ $order->user->name ?? 'Khách hàng' }}
                    </p>
                    <p class="text-sm text-gray-600">
                        {{ $order->created_at->diffForHumans() }}
                    </p>
                </div>

                <span class="px-3 py-1 rounded-full text-sm text-white
                    @if($order->status == 'pending') bg-blue-600
                    @elseif($order->status == 'completed') bg-green-600
                    @else bg-gray-600 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

        @empty
            <p class="text-gray-500 italic">Chưa có đơn hàng nào.</p>
        @endforelse

    </div>
</div>


</div>

@endsection
