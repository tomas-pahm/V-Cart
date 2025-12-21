{{-- resources/views/welcome.blade.php --}}
@extends('layouts.guest')

@section('title', 'Vegetas Cart - Thực Phẩm Hữu Cơ')

@section('content')

    <!-- Lời chào (nếu cần) -->
    <div class="my-5">
        <div class="bg-light border border-success rounded-3 shadow-sm p-5 p-lg-8 text-center">
            <h1 class="display-5 fw-bold text-success mb-3">
                Xin chào!
            </h1>
            <p class="lead text-muted fs-4">
                Chào mừng đến với cửa hàng rau củ hữu cơ tươi mỗi ngày
            </p>
        </div>
    </div>

    <!-- Tab danh mục giống dashboard -->
    <ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab-vegetable" data-toggle="tab">🥬 Rau củ</a>
    </li>
    <li>
        <a href="#tab-fruit" data-toggle="tab">🍎 Trái cây</a>
    </li>
    <li>
        <a href="#tab-dry" data-toggle="tab">🥫 Thực phẩm khô</a>
    </li>
</ul>

<div class="tab-content" style="margin-top:20px">
    <div class="tab-pane fade in active" id="tab-vegetable">
        @include('customer.partials.feature-rau')
    </div>
    <div class="tab-pane fade" id="tab-fruit">
        @include('customer.partials.feature-traicay')
    </div>
    <div class="tab-pane fade" id="tab-dry">
        @include('customer.partials.feature-thucphamkho')
    </div>
</div>


    <!-- Recommended Items -->
    <div class="recommended_items mt-5">
        <h2 class="title text-center">Gợi ý hôm nay</h2>
        <div id="recommended-item-carousel" class="carousel slide">
            <!-- Nội dung carousel giống template gốc -->
        </div>
    </div>

@endsection
