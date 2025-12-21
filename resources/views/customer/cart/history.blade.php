@extends('layouts.guest')

@section('title', 'Lịch sử giỏ hàng - Vegetas Cart')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/customer/cart/history.css') }}">
@endpush

@section('content')

<div class="features_items">
    <h2 class="title text-center text-success mb-4">Lịch sử giỏ hàng</h2>

    @if($historyItems->count() == 0)
        <div class="text-center" style="padding: 120px 0;">
            <img src="{{ asset('frontend/images/cart-empty.png') }}" alt="Không có lịch sử" width="120">
            <p class="lead mt-4" style="font-size: 26px; color:#666;">Bạn chưa có lịch sử giỏ hàng</p>
            <a href="{{ route('home') }}" class="btn btn-success btn-lg px-5">
                <i class="fa fa-arrow-left"></i> Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td>Sản phẩm</td>
                        <td>Mã</td>
                        <td>Đơn giá</td>
                        <td>Số lượng</td>
                        <td>Thời gian thêm</td>
                        <td>Thành tiền</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historyItems as $item)
                        @if(!$item->product) @continue @endif
                        <tr>
                            <td>
                                <img src="{{ asset('frontend/images/sanpham/' . ($item->product->images[0] ?? 'no-image.jpg')) }}"
                                     alt="{{ $item->product->name }}" width="100">
                                <div>{{ $item->product->name }}</div>
                            </td>
                            <td>{{ $item->product->product_id }}</td>
                            <td>{{ number_format($item->product->price) }}₫</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-danger fw-bold">{{ number_format($item->product->price * $item->quantity) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
