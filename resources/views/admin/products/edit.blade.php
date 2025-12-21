@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border p-8">
        <h1 class="text-3xl font-bold text-green-800 mb-2">Sửa sản phẩm</h1>
        <p class="text-green-600 mb-8">ID: {{ $product->product_id }} - {{ $product->name }}</p>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <!-- Giống hệt form create, chỉ thay value cũ -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Giá / 100g *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục *</label>
                    <select name="category_id" required class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->category_id }}"
                                {{ old('category_id', $product->category_id) == $cat->category_id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tồn kho</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                <textarea name="description" rows="6"
                          class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-3">
        Hình ảnh hiện tại
    </label>

    <div class="flex flex-wrap gap-4 mb-4">
        @if ($product->images && is_array($product->images) && count($product->images) > 0)
            @foreach ($product->images as $img)
    <img src="{{ asset('frontend/images/sanpham/' . $img) }}"
         alt="Ảnh sản phẩm"
         class="admin-product-preview">
@endforeach
        @else
            <p class="text-gray-500 italic">Chưa có ảnh nào</p>
        @endif
    </div>

    <label class="block text-sm font-medium text-gray-700 mb-2">
        Thay ảnh mới (chọn nhiều ảnh để thay thế hoàn toàn)
    </label>
    <input type="file"
           name="images[]"
           multiple
           accept="image/*"
           class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-green-600 file:text-white hover:file:bg-green-700 cursor-pointer">

    <p class="text-xs text-gray-500 mt-2">
        Lưu ý: Khi chọn ảnh mới → toàn bộ ảnh cũ sẽ bị thay thế
    </p>
</div>

            <div class="mt-8 flex gap-4">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow transition">
                    Cập nhật sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg shadow transition">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection