@extends('layouts.guest')

@section('title', "Kết quả tìm kiếm: {$query}")

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tìm kiếm: "{{ $query }}"</li>
        </ol>
    </nav>

    <!-- Hiển thị kết quả tìm kiếm -->
    @include('customer.partials.features_items', [
        'products' => $products,
        'title' => "Kết quả tìm kiếm: \"$query\""
    ])
@endsection
