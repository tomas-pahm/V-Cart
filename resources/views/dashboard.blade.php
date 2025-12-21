@extends('layouts.guest')

@section('title', 'Chào mừng quay lại - Vegetas Cart')

@section('content')
<div class="container px-0 px-md-3">

    <!-- Lời chào -->
    <div class="my-5">
        <div class="bg-light border border-success rounded-3 shadow-sm p-5 p-lg-8 text-center">
            <h1 class="display-5 fw-bold text-success mb-3">
                Xin chào, {{ auth()->user()->name }}!
            </h1>
            <p class="lead text-muted fs-4">
                Chào mừng quay lại cửa hàng rau củ hữu cơ tươi mỗi ngày
            </p>
        </div>
    </div>

    <!-- TABS -->
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab-vegetable" data-toggle="tab">  🥬 Rau Củ </a>
        </li>

        <li>
            <a href="#tab-fruit" data-toggle="tab">🍎 Trái Cây</a>
        </li>

        <li>
        <a href="#tab-dry" data-toggle="tab">🥜 Thực phẩm khô</a>
        </li>

    </ul>

    <div class="tab-content" style="margin-top:20px">

        <div class="tab-pane fade" id="tab-fruit">
            @include('customer.partials.feature-traicay')
        </div>

        <div class="tab-pane fade in active" id="tab-vegetable">
            @include('customer.partials.feature-rau')
        </div>

        <div class="tab-pane fade" id="tab-dry">
            @include('customer.partials.feature-thucphamkho')
        </div>

    </div>

</div>

@endsection
