@extends('layouts.admin')

@section('title', 'Sửa người dùng')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border p-8">

        {{-- TITLE --}}
        <h1 class="text-3xl font-bold text-green-800 mb-2">
            Sửa người dùng
        </h1>
        <p class="text-green-600 mb-8">
            ID: {{ $user->user_id }} – {{ $user->name }}
        </p>

        {{-- FORM --}}
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- NAME --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Họ tên *</label>
                    <input type="text" name="name"
                           value="{{ old('name', $user->name) }}"
                           required
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           required
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                </div>

                {{-- PHONE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                    <input type="text" name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                </div>

                {{-- ROLE — CHỈ SUPER ADMIN ĐƯỢC THẤY --}}
                @if(auth()->user()->role_id == 3)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vai trò</label>
                        <select name="role_id"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                            @foreach($roles as $role)
                                <option value="{{ $role->role_id }}" 
                                 {{ $user->role_id == $role->role_id ? 'selected' : '' }}>
                                  {{ $role->name }}
                                  </option>

                            @endforeach
                        </select>
                    </div>
                @endif

            </div>

            {{-- ADDRESS --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                <textarea name="address" rows="4"
                          class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">{{ old('address', $user->address) }}</textarea>
            </div>

            {{-- PASSWORD --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu (để trống nếu không đổi)</label>
                <input type="password" name="password"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
            </div>

            {{-- BUTTONS --}}
            <div class="mt-8 flex gap-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow transition">
                    Lưu thay đổi
                </button>

                <a href="{{ route('admin.users.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg shadow transition">
                    Quay lại
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
