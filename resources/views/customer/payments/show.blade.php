@extends('layouts.guest')

@section('title', 'Chi tiết thanh toán')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/customer/payments/show.css') }}">
@endpush

@section('content')



<div class="container py-4">

    <a href="{{ route('payments.index') }}" class="btn btn-outline-success mb-3">
        ← Quay lại danh sách thanh toán
    </a>

    <div class="card shadow-sm card-custom">
        <div class="card-header card-header-custom">
            Chi tiết thanh toán #{{ $payment->payment_id }}
        </div>

        <div class="card-body">

            {{-- THÔNG TIN THANH TOÁN --}}
            <div class="section-title">
                💳 Thông tin thanh toán
            </div>

            <div class="info-box">

                <div class="info-row"><strong>Mã thanh toán:</strong> {{ $payment->payment_id }}</div>
                <div class="info-row"><strong>Mã đơn hàng:</strong> #{{ $payment->order_id }}</div>
                <div class="info-row"><strong>Số tiền:</strong> 
                    <span class="text-danger fw-bold">{{ number_format($payment->amount) }}đ</span>
                </div>

                <div class="info-row"><strong>Phương thức:</strong> {{ strtoupper($payment->method) }}</div>

                <div class="info-row"><strong>Trạng thái:</strong>
                    @if ($payment->status === 'Success')
                        <span class="badge-custom badge-success">Đã thanh toán</span>
                    @elseif ($payment->status === 'Failed')
                        <span class="badge-custom badge-danger">Thất bại</span>
                    @else
                        <span class="badge-custom badge-warning">Chờ xử lý</span>
                    @endif
                </div>

                <div class="info-row">
                    <strong>Mã giao dịch cổng thanh toán:</strong>
                    {{ $payment->gateway_transaction_id ?? 'Không có' }}
                </div>

                <div class="info-row">
                    <strong>Thời gian thanh toán:</strong>
                    {{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : 'Chưa thanh toán' }}
                </div>
            </div>


            {{-- THÔNG TIN ĐƠN HÀNG --}}
            <div class="section-title">
                📦 Thông tin đơn hàng
            </div>

            <div class="info-box">

                <div class="info-row"><strong>Người nhận:</strong> {{ $payment->order->receiver_name }}</div>
                <div class="info-row"><strong>SĐT:</strong> {{ $payment->order->receiver_phone }}</div>
                <div class="info-row"><strong>Địa chỉ nhận hàng:</strong> {{ $payment->order->shipping_address }}</div>
                <div class="info-row"><strong>Ghi chú:</strong> {{ $payment->order->note ?? 'Không có' }}</div>

            </div>

        </div>
    </div>

</div>
@endsection
