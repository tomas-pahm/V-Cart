@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')

@section('content')

{{-- TIÊU ĐỀ --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-green-800">Người dùng</h1>
        <p class="text-green-600 mt-1">Quản lý toàn bộ tài khoản trong hệ thống</p>
    </div>
</div>

{{-- FILTER FORM --}}
<form method="GET" id="filterForm"
      class="bg-white rounded-xl shadow-md p-6 mb-8 border">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- TÌM KIẾM --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm người dùng</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Nhập tên hoặc email..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg
                          focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                   id="searchInput">
        </div>

        {{-- LỌC ROLE --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Vai trò</label>
            <select name="role"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                    id="roleSelect">
                <option value="">Tất cả vai trò</option>
                <option value="1" {{ request('role') == 1 ? 'selected' : '' }}>Customer</option>
                <option value="2" {{ request('role') == 2 ? 'selected' : '' }}>Admin</option>

                @if(auth()->user()->role_id == 3)
            <option value="3" {{ request('role') == 3 ? 'selected' : '' }}>Super Admin</option>
        @endif
            </select>
        </div>

        {{-- LỌC NGÀY TẠO --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">Ngày tạo</label>
    <select name="date" id="dateSelect"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
        <option value="">Tất cả</option>
        <option value="today"  {{ request('date')=='today'?'selected':'' }}>Hôm nay</option>
        <option value="week"   {{ request('date')=='week'?'selected':'' }}>7 ngày qua</option>
        <option value="month"  {{ request('date')=='month'?'selected':'' }}>Tháng này</option>
        <option value="custom" {{ request('date')=='custom'?'selected':'' }}>Tùy chỉnh</option>
    </select>

    <div id="customDateRange" class="mt-3 {{ request('date')=='custom'?'':'hidden' }}">
        <label class="block text-xs text-gray-600 mb-1">Từ ngày:</label>
        <input type="date" name="from" value="{{ request('from') }}"
               class="w-full px-3 py-2 border rounded-lg">

        <label class="block text-xs text-gray-600 mt-2 mb-1">Đến ngày:</label>
        <input type="date" name="to" value="{{ request('to') }}"
               class="w-full px-3 py-2 border rounded-lg">
    </div>
</div>


        {{-- RESET --}}
        @if(request()->hasAny(['search', 'role']))
            <div class="flex items-end">
                <a href="{{ route('admin.users.index') }}"
                   class="text-sm text-red-600 hover:text-red-800 underline">Xóa bộ lọc</a>
            </div>
        @endif
    </div>
</form>

{{-- BẢNG NGƯỜI DÙNG --}}
<div class="bg-white rounded-xl shadow-md border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            
            <thead class="!bg-green-700 !text-white">
                <tr class="border-b bg-gray-100 text-center">
                    <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Tên</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Vai trò</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Số điện thoại</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold">Ngày tạo</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold">Hành động</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)

                    <tr class="hover:bg-green-50 transition text-center">
                        <td class="px-6 py-4 text-gray-900 font-medium">
                            {{ $user->user_id }}
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $user->email }}
                        </td>

                        <td class="px-6 py-4 text-center whitespace-nowrap">
    @php
    $viewer = auth()->user()->role_id;   // Người đang xem
    $role = $user->role_id;              // Role của user trong bảng

    if ($viewer == 2) {
        // Admin: chỉ hiện Admin / Customer
        $label = $role == 1 ? 'Customer' : 'Admin';
    } else {
        // Super Admin: hiện đầy đủ
        $label = match($role) {
            1 => 'Customer',
            2 => 'Admin',
            3 => 'Super Admin',
            default => 'Unknown'
        };
    }
@endphp

<span style="
    background: {{ $label === 'Admin' ? '#d1fae5' : ($label === 'Super Admin' ? '#fef3c7' : '#f3f4f6') }};
    color: {{ $label === 'Admin' ? '#065f46' : ($label === 'Super Admin' ? '#92400e' : '#1f2937') }};
    padding: 6px 14px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    min-width: 110px;
">
    {{ $label }}
</span>

</td>




                        <td class="px-6 py-4 text-gray-700">
                            {{ $user->phone ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    Sửa
                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')"
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
                            Chưa có người dùng nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PHÂN TRANG --}}
    <div class="px-6 py-6 border-t bg-gray-50">
        {{ $users->links() }}
    </div>
</div>


<script>
document.getElementById('searchInput').addEventListener('input', function() {
    if (this.value.length >= 2 || this.value === '') {
        document.getElementById('filterForm').submit();
    }
});

document.getElementById('roleSelect').addEventListener('change', function() {
    document.getElementById('filterForm').submit();
});

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('filterForm');

    // Search auto submit
    document.getElementById('searchInput').addEventListener('input', function() {
        if (this.value.length >= 1 || this.value === '') form.submit();
    });

    // Role auto submit
    document.getElementById('roleSelect').addEventListener('change', () => form.submit());

    // Date auto submit
    const dateSelect = document.getElementById('dateSelect');
    const customRange = document.getElementById('customDateRange');
    const fromInput = document.querySelector('input[name="from"]');
    const toInput = document.querySelector('input[name="to"]');

    dateSelect.addEventListener('change', () => {
        if (dateSelect.value === 'custom') {
            customRange.classList.remove('hidden');
        } else {
            customRange.classList.add('hidden');
            form.submit();
        }
    });

    fromInput.addEventListener('change', () => {
        if (dateSelect.value === 'custom') form.submit();
    });

    toInput.addEventListener('change', () => {
        if (dateSelect.value === 'custom') form.submit();
    });
});
</script>

@endsection
