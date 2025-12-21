@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-green-800">Đơn hàng</h1>
        <p class="text-green-600 mt-1">Quản lý đơn hàng của khách hàng</p>
    </div>
</div>

{{-- FORM TÌM KIẾM --}}
<form method="GET" action="{{ route('admin.orders.index') }}" id="searchForm"
      class="bg-white rounded-xl shadow-md p-6 mb-8 border">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- MÃ ĐƠN HÀNG --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm theo mã đơn hàng</label>
            <input type="text"
                   name="order_id"
                   value="{{ request('order_id') }}"
                   placeholder="VD: 1023"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 
                          focus:ring-green-500 focus:border-green-500">
        </div>

        {{-- TÊN KHÁCH HÀNG --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tên khách hàng</label>
            <input type="text"
                   name="customer"
                   value="{{ request('customer') }}"
                   placeholder="Nhập tên khách hàng..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 
                          focus:ring-green-500 focus:border-green-500">
        </div>

        {{-- TRẠNG THÁI --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái đơn hàng</label>
            <select name="status"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 
                       focus:ring-green-500 focus:border-green-500">

                <option value="">-- Tất cả --</option>
                <option value="pending"     {{ request('status')=='pending'?'selected':'' }}>Chờ xử lý</option>
                <option value="confirmed"   {{ request('status')=='confirmed'?'selected':'' }}>Đã xác nhận</option>
                <option value="failed"      {{ request('status')=='failed'?'selected':'' }}>Thất bại</option>

            </select>
        </div>

        {{-- LỌC THEO NGÀY --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Lọc theo ngày</label>
    <select name="date" id="dateFilter"
        class="w-full px-4 py-2 border rounded-lg">
        <option value="">Tất cả</option>
        <option value="today"  {{ request('date')=='today'?'selected':'' }}>Hôm nay</option>
        <option value="week"   {{ request('date')=='week'?'selected':'' }}>Tuần này</option>
        <option value="month"  {{ request('date')=='month'?'selected':'' }}>Tháng này</option>
        <option value="custom" {{ request('date')=='custom'?'selected':'' }}>Tùy chỉnh</option>
    </select>
</div>

{{-- FROM + TO (ẨN KHI KHÔNG CHỌN "custom") --}}
<div id="customDateWrapper" class="{{ request('date') == 'custom' ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Từ ngày</label>
        <input type="date" name="from"
            value="{{ request('from') }}"
            class="w-full px-4 py-2 border rounded-lg">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Đến ngày</label>
        <input type="date" name="to"
            value="{{ request('to') }}"
            class="w-full px-4 py-2 border rounded-lg">
    </div>
</div>


    </div>

        {{-- NÚT SUBMIT ẨN ĐỂ ENTER HOẠT ĐỘNG --}}
    <button type="submit" class="hidden"></button>

    @if(request()->hasAny(['order_id','customer','status','date','from','to']))
    <div class="mt-4">
        <a href="{{ route('admin.orders.index') }}"
           class="text-sm text-red-600 hover:text-red-800 underline">
            Xóa bộ lọc
        </a>
    </div>
@endif


</form>


{{-- TABLE --}}
<div class="bg-white rounded-xl shadow-md border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="!bg-green-700 !text-white">
                <tr class="border-b bg-gray-100 text-center">
                    <th class="px-6 py-4 text-left text-sm font-semibold">Mã ĐH</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Khách hàng</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Tổng tiền</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Phương thức</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Thanh toán</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Trạng thái</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Ngày tạo</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Thao tác</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                @forelse ($orders as $order)
                <tr class="hover:bg-green-50 transition text-center">
                    <td class="px-6 py-4 font-semibold">
                        #{{ $order->order_id }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $order->user->name }}
                    </td>

                    <td class="px-6 py-4 text-green-700 font-bold">
                        {{ number_format($order->total_amount) }}đ
                    </td>

                    <td class="px-6 py-4 text-center">
    @if ($order->isCOD())
    <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">
        COD
    </span>
@else
    <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">
        Online
    </span>
@endif

</td>



                    <td class="px-6 py-4 text-center">
                        <span class="font-medium">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span class="font-semibold 
                            @if($order->order_status == 'completed') text-green-700
                            @elseif($order->order_status == 'processing') text-blue-600
                            @elseif($order->order_status == 'pending') text-yellow-600
                            @else text-red-600 @endif">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        {{ $order->created_at->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.orders.show', $order->order_id) }}"
                           class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                            Xem
                        </a>

                        @if($order->order_status == 'Pending')
    <form action="{{ route('admin.orders.approve', $order->order_id) }}" method="POST">
        @csrf
        <button type="submit"
                class="text-green-600 hover:text-green-800 font-medium text-sm"
                onclick="return confirm('Bạn có chắc muốn duyệt đơn này?')">
            Duyệt
        </button>
    </form>
    @endif
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-20 text-gray-500">
                        Chưa có đơn hàng nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PHÂN TRANG --}}
    <div class="px-6 py-6 border-t bg-gray-50">
        {{ $orders->links() }}
    </div>
</div>


<script>
const form = document.getElementById('searchForm');

// Auto search theo mã đơn hàng
document.querySelector('input[name="order_id"]').addEventListener('input', function() {
    if (this.value.length >= 1 || this.value === '') form.submit();
});

// Auto search theo tên KH
document.querySelector('input[name="customer"]').addEventListener('input', function() {
    if (this.value.length >= 1 || this.value === '') form.submit();
});

// Auto search theo trạng thái
document.querySelector('select[name="status"]').addEventListener('change', function() {
    form.submit();
});

// Lọc ngày
document.addEventListener('DOMContentLoaded', () => {

    const dateFilter = document.getElementById('dateFilter');
    const customWrapper = document.getElementById('customDateWrapper');
    const fromInput = document.querySelector('input[name="from"]');
    const toInput = document.querySelector('input[name="to"]');

    // Chọn preset (today/week/month)
    dateFilter.addEventListener('change', () => {
        if (dateFilter.value === 'custom') {
            customWrapper.classList.remove('hidden');
        } else {
            customWrapper.classList.add('hidden');
            form.submit();  
        }
    });

    // Auto submit khi thay đổi ngày tùy chỉnh
    fromInput.addEventListener('change', () => {
        if (dateFilter.value === 'custom') form.submit();
    });

    toInput.addEventListener('change', () => {
        if (dateFilter.value === 'custom') form.submit();
    });
});
</script>





@endsection
