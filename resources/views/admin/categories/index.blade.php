@extends('layouts.admin')

@section('title', 'Quản lý Danh mục')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-green-800">Danh mục</h1>
        <p class="text-green-600 mt-1">Quản lý danh mục sản phẩm của cửa hàng</p>
    </div>

    <a href="{{ route('admin.categories.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Thêm danh mục
    </a>
</div>

{{-- FORM TÌM KIẾM --}}
<form method="GET" action="{{ route('admin.categories.index') }}" id="filterForm"
      class="bg-white rounded-xl shadow-md p-6 mb-8 border">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Search --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
            <input type="text" name="search" id="searchInput"
                value="{{ request('search') }}"
                placeholder="Tên danh mục..."
                class="w-full px-4 py-2 border rounded-lg">
        </div>

        {{-- Has Product --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sản phẩm</label>
            <select name="has_product" id="hasProductSelect"
                    class="w-full px-4 py-2 border rounded-lg">
                <option value="">Tất cả</option>
                <option value="1" {{ request('has_product') == '1' ? 'selected' : '' }}>Có sản phẩm</option>
                <option value="0" {{ request('has_product') == '0' ? 'selected' : '' }}>Không có sản phẩm</option>
            </select>
        </div>

        {{-- DATE FILTER --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ngày tạo</label>
            <select name="date" id="dateSelect"
                    class="w-full px-4 py-2 border rounded-lg">
                <option value="">Tất cả</option>
                <option value="today"  {{ request('date') == 'today' ? 'selected' : '' }}>Hôm nay</option>
                <option value="week"   {{ request('date') == 'week' ? 'selected' : '' }}>7 ngày qua</option>
                <option value="month"  {{ request('date') == 'month' ? 'selected' : '' }}>Tháng này</option>
                <option value="custom" {{ request('date') == 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
            </select>
        </div>

        {{-- CUSTOM DATE RANGE --}}
        <div id="customDateRange" class="{{ request('date') == 'custom' ? '' : 'hidden' }}">
            <label class="block text-xs text-gray-600 mb-1">Từ ngày</label>
            <input type="date" name="created_from" value="{{ request('created_from') }}"
                   class="w-full px-3 py-2 border rounded-lg">

            <label class="block text-xs text-gray-600 mt-2 mb-1">Đến ngày</label>
            <input type="date" name="created_to" value="{{ request('created_to') }}"
                   class="w-full px-3 py-2 border rounded-lg">
        </div>

    </div>

    <div class="mt-4">
        @if(request()->anyFilled(['search','has_product','date','created_from','created_to']))
            <a href="{{ route('admin.categories.index') }}" class="text-red-600 underline">
                Xóa bộ lọc
            </a>
        @endif
    </div>
</form>



{{-- TABLE --}}
<div class="bg-white rounded-xl shadow-md border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="!bg-green-700 !text-white">
                <tr class="border-b bg-gray-100 text-center">
                    <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Tên danh mục</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Số sản phẩm</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Thao tác</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($categories as $cat)
                    <tr class="hover:bg-green-50 transition text-center">
                        <td class="px-6 py-4">{{ $cat->category_id }}</td>

                        <td class="px-6 py-4 font-semibold">{{ $cat->name }}</td>

                        <td class="px-6 py-4 text-center text-green-700 font-bold">
                            {{ $cat->products_count }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('admin.categories.edit', $cat) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">Sửa</a>

                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-medium text-sm">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-20 text-gray-500">
                            Chưa có danh mục nào.<br>
                            <a href="{{ route('admin.categories.create') }}" 
                               class="text-green-600 underline hover:text-green-800">
                                Thêm danh mục đầu tiên ngay!
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PHÂN TRANG --}}
    <div class="px-6 py-6 border-t bg-gray-50">
        {{ $categories->links() }}
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    if (this.value.length >= 2 || this.value === '') {
        document.getElementById('filterForm').submit();
    }
});

document.getElementById('hasProductSelect').addEventListener('change', function () {
    document.getElementById('filterForm').submit();
});

document.getElementById('dateSelect').addEventListener('change', function () {
    document.getElementById('customDateRange')
        .classList.toggle('hidden', this.value !== 'custom');

    if (this.value !== 'custom') {
        document.getElementById('filterForm').submit();
    }
});

document.querySelector('input[name="created_from"]').addEventListener('change', function () {
    document.getElementById('filterForm').submit();
});

document.querySelector('input[name="created_to"]').addEventListener('change', function () {
    document.getElementById('filterForm').submit();
});
</script>


@endsection
