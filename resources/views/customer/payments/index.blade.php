@extends('layouts.guest')

@section('title', 'Lịch sử thanh toán')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/customer/payments/index.css') }}">
@endpush

@section('content')


<div class="container py-4">
    <h2 class="mb-4 fw-bold text-success">📄 Lịch sử thanh toán</h2>

    @if ($payments->isEmpty())
        <div class="text-center py-5">
            <img src="{{ asset('frontend/images/cart-empty.png') }}" width="120">
            <p class="mt-3 text-muted" style="font-size: 18px;">Bạn chưa có hóa đơn thanh toán nào.</p>
            <a href="{{ route('home') }}" class="btn btn-success px-4 py-2 mt-2">
                <i class="fa fa-shopping-basket"></i> Mua sắm ngay
            </a>
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered payment-table align-middle">
                <thead>
                    <tr>
                        <th>Mã thanh toán</th>
                        <th>Mã đơn hàng</th>
                        <th>Phương thức</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Thời gian</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td class="fw-bold text-success">#{{ $payment->payment_id }}</td>

                            <td>
                                <span class="fw-bold">#{{ $payment->order_id }}</span>
                            </td>

                            <td>{{ strtoupper($payment->method) }}</td>

                            <td class="fw-bold text-danger">{{ number_format($payment->amount) }}₫</td>

                            <td>
                                @if ($payment->status === 'Success')
                                    <span class="badge badge-success">Đã thanh toán</span>
                                @elseif ($payment->status === 'Failed')
                                    <span class="badge badge-danger">Thất bại</span>
                                @else
                                    <span class="badge badge-warning">Chờ xử lý</span>
                                @endif
                            </td>

                            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>

                            <td>
                                <a href="{{ route('payments.show', $payment) }}" class="btn-detail">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endif
</div>
@endsection
