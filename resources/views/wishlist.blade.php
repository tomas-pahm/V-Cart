@extends('layouts.guest')

@section('title', 'Sản phẩm yêu thích của tôi')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Yêu thích</li>
        </ol>
    </nav>

    <!-- Hiển thị wishlist -->
    @include('customer.partials.features_items', [
        'products' => $wishlistProducts,   {{-- truyền danh sách sản phẩm yêu thích --}}
        'title' => 'Sản phẩm yêu thích của tôi'
    ])
@endsection
