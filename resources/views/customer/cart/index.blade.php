@extends('layouts.guest')

@section('title', 'Giỏ hàng - Vegetas Cart')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/customer/cart/index.css') }}">
@endpush

@section('content')
<div class="features_items">
    <h2 class="title text-center" style="color:#2E7D32; margin-bottom:30px;">
        Giỏ hàng của bạn
    </h2>

    @if($cartItems->count() == 0)
        <div class="text-center" style="padding: 120px 0;">
            <img src="{{ asset('frontend/images/cart-empty.png') }}" alt="Giỏ hàng trống" width="120">
            <p class="lead mt-4" style="font-size: 26px; color:#666;">Giỏ hàng đang trống</p>
            <a href="{{ route('home') }}" class="btn btn-success btn-lg px-5">
                <i class="fa fa-arrow-left"></i> Tiếp tục mua sắm
            </a>
        </div>
    @else
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu" style="background:#2E7D32; color:white;">
                        <td class="image">Sản phẩm</td>
                        <td class="description"></td>
                        <td class="price">Đơn giá</td>
                        <td class="quantity text-center">Số lượng</td>
                        <td class="total">Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        @if(!$item->product) @continue @endif

                        <tr style="border-bottom:1px solid #eee;">
                            <td class="cart_product" width="120">
                                <img src="{{ asset('frontend/images/sanpham/' . ($item->product->images[0] ?? 'no-image.jpg')) }}"
                                     alt="{{ $item->product->name }}"
                                     width="100" height="100"
                                     class="img-responsive rounded shadow-sm">
                            </td>

                            <td class="cart_description">
                                <h4 class="mb-1">{{ $item->product->name }}</h4>
                                {{-- Nút Wishlist --}}
        <button class="wishlist-btn btn p-0 border-0 bg-transparent position-absolute d-flex align-items-center justify-content-center"
            data-product-id="{{ $item->product->product_id }}"
            style="top: 6px; right: 6px; width: 36px; height: 36px; z-index: 20;
                   border-radius: 50%; background: rgba(0, 0, 0, 0.45);
                   backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
                   transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">

            <span class="heart-icon fs-5">
                @if(auth()->user() && auth()->user()->wishlists->contains('product_id', $item->product->product_id))
                    ❤️
                @else
                    🤍
                @endif
            </span>
        </button>
                                <small class="text-muted">Mã: {{ $item->product->product_id }}</small>
                            </td>

                            <td class="cart_price" width="140">
                                <strong class="text-success">
                                    {{ number_format($item->product->price) }}₫
                                </strong><br>
                                <small class="text-muted">/ 100g</small>
                                <div class="text-muted small">
                                    ({{ number_format($item->product->price * 10) }}₫/kg)
                                </div>
                            </td>

                            <td class="cart_quantity text-center" width="140">
                                <form action="{{ route('cart.update', $item->cart_item_id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                           min="1" class="form-control text-center d-inline-block"
                                           style="width:80px;" required>
                                    <br>
                                    <small class="text-success fw-bold">
                                        {{ $item->quantity * 100 }}g
                                    </small>
                                </form>
                            </td>

                            <td class="cart_total text-end" width="140">
                                <p class="cart_total_price h5 text-danger fw-bold mb-0">
                                    {{ number_format($item->product->price * $item->quantity) }}₫
                                </p>
                            </td>

                            <td class="cart_delete" width="50">
                                <form action="{{ route('cart.remove', $item->cart_item_id) }}" method="POST" class="delete-cart-item-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="cart_quantity_delete btn btn-sm btn-link text-danger p-0">
        <i class="fa fa-times fa-lg"></i>
    </button>
</form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tổng kết -->
        <div class="text-end mt-4 p-4 bg-light rounded shadow-sm">
            <h3 class="mb-3">
                Tổng cộng: 
                <span class="text-danger fw-bold" style="font-size:1.6rem;">
                    {{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity)) }}₫
                </span>
            </h3>
            <p class="text-muted mb-3">
                <strong>{{ $cartItems->sum('quantity') }}</strong> phần × 100g 
                = <strong>{{ number_format($cartItems->sum('quantity') * 100) }}g</strong> 
                ({{ $cartItems->sum('quantity') / 10 }} kg)
            </p>

         <button type="button"
        class="btn btn-success btn-lg"
        data-toggle="modal"
        data-target="#checkoutModal">
    <i class="fa fa-credit-card"></i> Thanh toán
</button>


<!-- MODAL THANH TOÁN -->
<div class="modal fade checkout-modal" id="checkoutModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">

      <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <!-- HEADER -->
        <div class="modal-header checkout-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
            <i class="fa fa-lock"></i> Thanh toán an toàn
          </h4>
        </div>

        <!-- BODY -->
        <div class="modal-body">

          <div class="row">

            <!-- LEFT -->
            <div class="col-md-7">
              <h5 class="section-title">📍 Thông tin giao hàng</h5>

              <div class="form-group">
                <label>Địa chỉ nhận hàng</label>
                <input type="text" name="shipping_address" class="form-control"
                       value="{{ auth()->user()->address ?? '' }}"
                       placeholder="Nhập địa chỉ giao hàng">
              </div>

              <div class="form-group">
                <label>Ghi chú</label>
                <textarea name="order_note" rows="3"
                          class="form-control"
                          placeholder="Giao giờ hành chính, gọi trước khi giao..."></textarea>
              </div>

              <h5 class="section-title mt-4">💳 Thanh toán</h5>

              <label class="payment-option">
                <input type="radio" name="method" value="cod" checked>
                <span>
                  <i class="fa fa-money"></i> Thanh toán khi nhận hàng (COD)
                </span>
              </label>

              <label class="payment-option">
                <input type="radio" name="method" value="online">
                <span>
                  <i class="fa fa-credit-card"></i> Thanh toán Online
                </span>
              </label>
            </div>

            <!-- RIGHT -->
            <div class="col-md-5">
              <div class="order-summary">
                <h5>🧾 Đơn hàng</h5>

                <p>
                  Tổng tiền:
                  <span class="price">
                    {{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity)) }}₫
                  </span>
                </p>

                <p class="text-muted">
                  {{ $cartItems->sum('quantity') * 100 }}g
                  ({{ $cartItems->sum('quantity') / 10 }}kg)
                </p>

                <hr>

                <p class="small text-muted">
                  Bằng việc đặt hàng, bạn đồng ý với điều khoản của Vegetas
                </p>

                <button type="submit" class="btn btn-place-order btn-block">
                  <i class="fa fa-check"></i> Đặt hàng
                </button>
              </div>
            </div>

          </div>
        </div>

      </form>

    </div>
  </div>
</div>

        </div>
    @endif
</div>
@endsection