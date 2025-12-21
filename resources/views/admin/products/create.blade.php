@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border p-8">
        <h1 class="text-3xl font-bold text-green-800 mb-2">Thêm sản phẩm mới</h1>
        <p class="text-green-600 mb-8">Điền đầy đủ thông tin sản phẩm</p>
        
        @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tên sản phẩm -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm *</label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ví dụ: Cà chua hữu cơ Đà Lạt">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Giá / 100g -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Giá bán (đồng / 100g) *</label>
                    <input type="number" name="price" required min="1000" step="1000"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500"
                           placeholder="35000">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Danh mục -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục *</label>
                    <select name="category_id" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->category_id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tồn kho -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng tồn kho</label>
                    <input type="number" name="stock" value="100" min="0"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <!-- Mô tả -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả chi tiết</label>
                <textarea name="description" rows="6"
                          class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500"
                          placeholder="Nguồn gốc, cách bảo quản, lợi ích sức khỏe..."></textarea>
            </div>

            <!-- Upload ảnh -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh sản phẩm (tối đa 5 ảnh)</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="w-full px-4 py-3 border rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-green-600 file:text-white">
                <p class="text-xs text-gray-500 mt-2">Chọn nhiều ảnh cùng lúc (Ctrl + click)</p>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow transition">
                    Thêm sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg shadow transition">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>
@endsection