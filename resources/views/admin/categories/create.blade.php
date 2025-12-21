@extends('layouts.admin')

@section('title', 'Thêm danh mục mới')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border p-8">

        <h1 class="text-3xl font-bold text-green-800 mb-2">Thêm danh mục mới</h1>
        <p class="text-green-600 mb-8">Điền thông tin danh mục</p>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            {{-- Tên danh mục --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tên danh mục *</label>
                <input type="text" name="name" required
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500"
                       placeholder="Ví dụ: Rau củ">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow transition">
                    Thêm danh mục
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg shadow transition">
                    Hủy bỏ
                </a>
            </div>
        </form>

    </div>
</div>
@endsection
