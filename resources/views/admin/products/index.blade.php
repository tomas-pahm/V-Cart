@extends('layouts.admin')

@section('title', 'Quản lý Sản phẩm')

@section('content')

{{-- TIÊU ĐỀ + NÚT THÊM MỚI --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-green-800">Sản phẩm</h1>
        <p class="text-green-600 mt-1">Quản lý tất cả sản phẩm trong cửa hàng</p>
    </div>

    <a href="{{ route('admin.products.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Thêm sản phẩm mới
    </a>
</div>

{{-- THẺ TÌM KIẾM + LỌC – ĐÃ HOÀN HẢO 100% --}}
<form method="GET" action="{{ route('admin.products.index') }}" id="filterForm" class="bg-white rounded-xl shadow-md p-6 mb-8 border">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- TÌM KIẾM TÊN -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm sản phẩm</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nhập tên sản phẩm..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                   id="searchInput">
        </div>

        <!-- LỌC DANH MỤC -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục</label>
            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" id="categorySelect">
                <option value="">Tất cả danh mục</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- LỌC TỒN KHO -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái tồn kho</label>
            <select name="stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" id="stockSelect">
                <option value="">Tất cả</option>
                <option value="in_stock" {{ request('stock') == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                <option value="low_stock" {{ request('stock') == 'low_stock' ? 'selected' : '' }}>Sắp hết (≤ 10)</option>
                <option value="out_of_stock" {{ request('stock') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
            </select>
        </div>
    </div>

    <!-- LỌC NGÀY TẠO -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Ngày tạo</label>
    <select name="date" id="dateSelect"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
        <option value="">Tất cả</option>
        <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Hôm nay</option>
        <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>7 ngày qua</option>
        <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Tháng này</option>
        <option value="custom" {{ request('date') == 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
    </select>

    <!-- CHỌN NGÀY TÙY CHỈNH -->
    <div id="customDateRange" class="mt-3 {{ request('date') == 'custom' ? '' : 'hidden' }}">
        <label class="block text-xs text-gray-600 mb-1">Từ ngày:</label>
        <input type="date" name="from" value="{{ request('from') }}"
               class="w-full px-3 py-2 border rounded-lg">

        <label class="block text-xs text-gray-600 mt-2 mb-1">Đến ngày:</label>
        <input type="date" name="to" value="{{ request('to') }}"
               class="w-full px-3 py-2 border rounded-lg">
    </div>
</div>


    <!-- NÚT RESET (TÙY CHỌN) -->
    @if(request()->hasAny(['search', 'category', 'stock']))
        <div class="mt-4">
            <a href="{{ route('admin.products.index') }}" class="text-sm text-red-600 hover:text-red-800 underline">
                Xóa bộ lọc
            </a>
        </div>
    @endif
</form>

{{-- BẢNG SẢN PHẨM --}}
<div class="bg-white rounded-xl shadow-md border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="!bg-green-700 !text-white">
                <tr class="border-b bg-gray-100 text-center">
                    <th class="px-6 py-4 text-left text-sm font-semibold">Hình ảnh</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Tên sản phẩm</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Danh mục</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Giá</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Tồn kho</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Trạng thái</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
            
                    <tr class="hover:bg-green-50 transition text-center">

                        {{-- CỘT ẢNH – ĐÃ HOÀN HẢO, ẢNH HIỆN ĐẸP LUÔN --}}
                        <td class="px-6 py-4">
                            @if ($product->images && is_array($product->images) && count($product->images) > 0)
                                <img src="{{ asset('frontend/images/sanpham/' . $product->images[0]) }}"
     alt="{{ $product->name }}"
     class="admin-product-thumb">
                            @else
                                <div class="w-16 h-16 bg-gray-200 border-2 border-dashed rounded-lg flex items-center justify-center">
                                    <span class="text-xs text-gray-500">No image</span>
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">ID: {{ $product->product_id }}</p>
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $product->category?->name ?? 'Chưa có danh mục' }}
                        </td>

                        <td class="px-6 py-4 text-center font-bold text-green-700">
                            {{ number_format($product->price, 0, ',', '.') }}đ
                        </td>

                        <td class="px-6 py-4 text-center">
                            <span class="font-bold @if($product->stock == 0) text-red-600 @elseif($product->stock <= 10) text-orange-600 @else text-green-600 @endif">
                                {{ $product->stock }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($product->stock > 0)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Còn hàng</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Hết hàng</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">Sửa</a>

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')"
                                            class="text-red-600 hover:text-red-800 font-medium text-sm">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-16 text-gray-500">
                            Chưa có sản phẩm nào.<br>
                            <a href="{{ route('admin.products.create') }}" class="text-green-600 underline hover:text-green-800">Thêm sản phẩm đầu tiên ngay!</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PHÂN TRANG --}}
    <div class="px-6 py-6 border-t bg-gray-50">
        {{ $products->links() }}
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    if (this.value.length >= 2 || this.value === '') {
        document.getElementById('filterForm').submit();
    }
});

document.getElementById('categorySelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

document.getElementById('stockSelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

// LỌC NGÀY
document.getElementById('dateSelect').addEventListener('change', function () {
    document.getElementById('customDateRange')
        .classList.toggle('hidden', this.value !== 'custom');

    // Ngày hôm nay, tuần, tháng → auto lọc
    if (this.value !== 'custom') {
        document.getElementById('filterForm').submit();
    }
});

// LỌC NGÀY TÙY CHỈNH
document.querySelector('input[name="from"]').addEventListener('change', function () {
    document.getElementById('filterForm').submit();
});

document.querySelector('input[name="to"]').addEventListener('change', function () {
    document.getElementById('filterForm').submit();
});

</script>

@endsection