@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-800">
            Đơn hàng #{{ $order->order_id }}
        </h1>
        <p class="text-green-600 mt-1">
            Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
        </p>
    </div>

    {{-- THÔNG TIN CHUNG --}}
    <div class="bg-white rounded-xl shadow-md border p-6 mb-8">

        <h2 class="text-xl font-semibold text-gray-800 mb-4">Thông tin đơn hàng</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">

            <div>
                <p class="mb-2"><strong>Khách hàng:</strong> {{ $order->user->name }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ $order->user->email }}</p>
                <p class="mb-2"><strong>Số điện thoại:</strong> {{ $order->receiver_phone }}</p>
            </div>

            <div>
                <p class="mb-2"><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>

                <p class="mb-2"><strong>Thanh toán:</strong>
                    @if (trim(strtolower($order->payment_status)) === 'paid')
    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
        Đã thanh toán
    </span>
@else
    <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
        Chưa thanh toán
    </span>
@endif

                </p>

                <p class="mb-2"><strong>Trạng thái đơn:</strong>
                    @php
                        $colors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'shipping' => 'bg-blue-100 text-blue-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                        ];
                    @endphp

                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$order->order_status] ?? 'bg-gray-200' }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </p>
            </div>

        </div>

        @if ($order->note)
            <div class="mt-4 text-gray-700">
                <strong>Ghi chú:</strong> {{ $order->note }}
            </div>
        @endif

    </div>

    {{-- DANH SÁCH SẢN PHẨM --}}
    <div class="bg-white rounded-xl shadow-md border">

        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold text-gray-800">Sản phẩm trong đơn</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gradient-to-r from-green-600 to-emerald-700 text-white">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Sản phẩm</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Số lượng</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Giá</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Tạm tính</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                @foreach ($order->items as $item)
                    <tr class="hover:bg-green-50 transition">

                        {{-- TÊN + ẢNH --}}
                        <td class="px-6 py-4 flex items-center gap-4">

                            @if ($item->product->images && count($item->product->images))
                                <img src="{{ asset('frontend/images/sanpham/' . $item->product->images[0]) }}"
                                     alt=""
                                     class="w-14 h-14 object-cover rounded-lg border">
                            @else
                                <div class="w-14 h-14 bg-gray-200 rounded-lg flex items-center justify-center text-xs text-gray-500">
                                    No image
                                </div>
                            @endif

                            <span class="font-semibold text-gray-800">
                                {{ $item->product->name }}
                            </span>
                        </td>

                        {{-- SỐ LƯỢNG --}}
                        <td class="px-6 py-4 text-center font-semibold text-gray-700">
                            {{ $item->quantity }}
                        </td>

                        {{-- GIÁ --}}
                        <td class="px-6 py-4 text-center text-green-700 font-bold">
                            {{ number_format($item->price) }}đ
                        </td>

                        {{-- TẠM TÍNH --}}
                        <td class="px-6 py-4 text-center text-green-800 font-bold">
                            {{ number_format($item->price * $item->quantity) }}đ
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        {{-- TỔNG TIỀN --}}
        <div class="px-6 py-6 border-t bg-gray-50 flex justify-end">
            <div class="text-xl font-bold text-green-800">
                Tổng cộng: {{ number_format($order->total_amount) }}đ
            </div>
        </div>

    </div>

    {{-- NÚT QUAY LẠI --}}
    <div class="mt-8">
        <a href="{{ route('admin.orders.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-8 rounded-lg shadow transition">
            Quay lại danh sách
        </a>
    </div>

</div>

@endsection
