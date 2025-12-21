{{-- resources/views/products/detail.blade.php --}}
@extends('layouts.guest')
@section('title', $product->name . ' - Chi tiết sản phẩm')

@section('content')
<div class="container py-4 py-lg-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent ps-0 mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted">Trang chủ</a></li>
            @if($product->category)
                <li class="breadcrumb-item text-success fw-bold">{{ $product->category->name }}</li>
            @endif
            <li class="breadcrumb-item active text-success fw-bold fs-5">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4 g-xl-5">
        <!-- === PHẦN ẢNH SẢN PHẨM (Trái) === -->
<div class="col-lg-6">
    <div class="sticky-top" style="top: 90px;">
        <!-- Ảnh chính - SIÊU ĐẸP, KHÔNG BAO GIỜ BỊ MÉO, KHÔNG TRÀN MÀN HÌNH -->
        <div class="text-center bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="d-inline-block position-relative">
                <img src="{{ $product->images ? asset('frontend/images/sanpham/' . $product->images[0]) : asset('images/no-image.jpg') }}"
                     alt="{{ $product->name }}"
                     class="img-fluid rounded-3 shadow"
                     style="
                        max-height: 580px;      /* Giới hạn chiều cao tối đa */
                        max-width: 100%;        /* Không vượt quá khung */
                        height: auto;           /* Giữ tỷ lệ gốc */
                        width: auto;            /* Giữ tỷ lệ gốc */
                        object-fit: contain;    /* Không méo */
                        display: block;
                        margin: 0 auto;
                     ">
            </div>
        </div>

        <!-- Thumbnail nhỏ (giữ nguyên, đẹp rồi) -->
        @if($product->images && count($product->images) > 1)
        <div class="row g-2 justify-content-center">
            @foreach(array_slice($product->images, 1, 6) as $index => $img)
            <div class="col-2">
                <img src="{{ asset('frontend/images/sanpham/' . $img) }}"
                     class="img-fluid rounded-3 border thumbnail-img cursor-pointer shadow-sm hover-shadow
                            {{ $index === 0 ? 'border-success border-3' : 'border' }}"
                     style="height: 90px; object-fit: cover;"
                     onclick="
                        document.querySelector('.text-center img').src = this.src;
                        document.querySelectorAll('.thumbnail-img').forEach(t => t.classList.remove('border-success','border-3'));
                        this.classList.add('border-success','border-3');
                     ">
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

        <!-- === PHẦN THÔNG TIN (Phải) === -->
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <h1 class="fw-bold fs-2 mb-3 text-success">{{ $product->name }}</h1>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="text-muted">Danh mục:</span>
                    <span class="badge bg-success fs-6 px-3 py-2">{{ $product->category?->name ?? 'Chưa phân loại' }}</span>


                    @auth
    <button class="wishlist-btn btn p-0 border-0 bg-transparent d-flex align-items-center justify-content-center"
            data-product-id="{{ $product->product_id }}"
            style="
                width:48px;
                height:48px;
                border-radius:50%;
                background: rgba(255,255,255,0.85);
                box-shadow: 0 4px 15px rgba(0,0,0,0.25);
                transition: .3s;
            ">
        <span class="heart-icon fs-4">
            @if(auth()->user()->wishlists->contains('product_id', $product->product_id))
                ❤️
            @else
                🤍
            @endif
        </span>
    </button>
    @endauth
                </div>

                <!-- Giá -->
                <div class="bg-light p-4 rounded-3 mb-4 border-start border-5 border-danger">
                    <div class="d-flex align-items-end gap-3">
                        <h2 class="text-danger fw-bold mb-0 fs-1">{{ $product->formatted_price }}</h2>
                        <span class="text-muted fs-5">≈ {{ $product->formatted_price_per_kg }}</span>
                    </div>
                    <small class="text-muted">Giá tính theo mỗi 100g • Đơn vị bán: 100g/phần</small>
                </div>

                <!-- Tồn kho -->
                <div class="alert alert-soft-success d-flex align-items-center gap-3 mb-4">
                    <i class="fas fa-box fs-4"></i>
                    <div>
                        <strong>Tình trạng:</strong>
                        <span class="{{ $product->stock > 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ $product->stock > 0 ? "Còn hàng ({$product->stock} x 100g)" : "Hết hàng" }}
                        </span>
                    </div>
                </div>

                <!-- Chọn số lượng -->
                <form id="add-to-cart-form" data-product-id="{{ $product->product_id }}" class="mb-5">
                    @csrf
                    <div class="row align-items-end g-4">
                        <div class="col-auto">
                            <label class="form-label fw-bold fs-5 mb-3">Chọn số lượng</label>
                            <div class="input-group input-group-lg" style="width: 180px;">
                                <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
                                <input type="text" id="quantity" class="form-control text-center fw-bold fs-4" value="1" readonly>
                                <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
                            </div>
                            <div class="text-muted mt-2">
                                <small>Tổng: <strong><span id="total-weight">100</span>g</strong> 
                                ({{ $product->stock > 0 ? 'Tối đa ' . $product->stock . ' phần' : 'Hết hàng' }})</small>
                            </div>
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-danger btn-lg px-5 py-3 shadow-lg rounded-pill fw-bold fs-5"
                                    style="min-width: 220px;" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-cart-plus me-2"></i>
                                {{ $product->stock > 0 ? 'Thêm vào giỏ hàng' : 'Hết hàng' }}
                            </button>

                        </div>
                    </div>
                </form>

                <!-- Thông tin giao hàng -->
                <div class="bg-light p-4 rounded-3 border">
                    <div class="row g-3">
                        <div class="col-12 d-flex align-items-center gap-3">
                            <i class="fas fa-truck text-success fs-4"></i>
                            <div>
                                <strong>Giao hàng toàn quốc</strong><br>
                                <small class="text-muted">Thanh toán khi nhận hàng (COD) • Miễn phí nội thành</small>
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-center gap-3">
                            <i class="fas fa-shield-alt text-success fs-4"></i>
                            <div>
                                <strong>Cam kết chất lượng</strong><br>
                                <small class="text-muted">Hàng tươi mới mỗi ngày • Đổi trả trong 24h</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab mô tả & liên quan -->
    <div class="mt-5">
        <ul class="nav nav-tabs border-bottom-0" id="productTab">
            <li class="nav-item">
                <button class="nav-link active px-4 py-3 fs-5" data-bs-toggle="tab" data-bs-target="#desc">Mô tả sản phẩm</button>
            </li>
            <li class="nav-item">
                <button class="nav-link px-4 py-3 fs-5" data-bs-toggle="tab" data-bs-target="#related">Sản phẩm liên quan</button>
            </li>
        </ul>

        <div class="tab-content bg-white p-4 rounded-bottom shadow-sm">
            <div class="tab-pane fade show active" id="desc">
                <div class="prose max-w-none">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            <div class="tab-pane fade" id="related">
                <div class="row g-4">
                    @foreach($relatedProducts as $related)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                            <a href="{{ route('product.detail', $related->product_id) }}">
                                <img src="{{ asset('frontend/images/sanpham/' . ($related->images[0] ?? 'default.jpg')) }}"
                                     class="card-img-top" style="height: 180px; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="card-title mb-2">{{ Str::limit($related->name, 40) }}</h6>
                                <p class="text-danger fw-bold fs-5 mb-2">{{ $related->formatted_price }}</p>
                                <a href="{{ route('product.detail', $related->product_id) }}"
                                   class="btn btn-sm btn-outline-success mt-auto">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
    <div id="cartToast" class="toast align-items-center text-white bg-success border-0 shadow-lg" role="alert">
        <div class="d-flex">
            <div class="toast-body fw-bold">
                Đã thêm vào giỏ hàng!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/customer/products/detail.css') }}">
@endpush



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const qty       = document.getElementById('quantity');
    const total     = document.getElementById('total-weight');
    const decrease  = document.getElementById('decrease');
    const increase  = document.getElementById('increase');
    const form      = document.getElementById('add-to-cart-form');

    if (!qty || !total || !decrease || !increase || !form) return;

    const maxStock = {{ $product->stock }};

    const updateTotal = () => total.textContent = qty.value * 100;

    increase.addEventListener('click', () => {
        let v = parseInt(qty.value);
        if (v < maxStock) qty.value = ++v;
        updateTotal();
    });

    decrease.addEventListener('click', () => {
        let v = parseInt(qty.value);
        if (v > 1) qty.value = --v;
        updateTotal();
    });

    qty.addEventListener('input', () => {
        let v = qty.value.replace(/\D/g, '') || '1';
        v = Math.max(1, Math.min(v, maxStock));
        qty.value = v;
        updateTotal();
    });

    // XÓA TOAST XANH BOOTSTRAP
    document.querySelectorAll('#cartToast, .toast').forEach(el => el.remove());

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        const quantity = parseInt(qty.value);

        fetch('/cart/add2/{{ $product->product_id }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Đã thêm vào giỏ!',
                    text: `+${quantity} phần (${quantity * 100}g)`,
                    timer: 2000,
                    timerProgressBar: true,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    // MÀU TRUNG TÍNH SIÊU ĐẸP – CHỈ ICON LÀ XANH
                    background: '#ffffff',
                    color: '#212529',
                    iconColor: '#28a745',        // icon xanh lá
                    customClass: {
                        popup: 'border border-success shadow-lg'
                    }
                });

                const el = document.getElementById('cart-count');
                if (el) {
                    el.textContent = data.cartCount;
                    el.classList.add('animate__animated', 'animate__tada');
                    setTimeout(() => el.classList.remove('animate__animated', 'animate__tada'), 1000);
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Không thể thêm',
                    text: data.message || 'Có lỗi xảy ra',
                    timer: 2500,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    background: '#ffffff',
                    color: '#212529',
                    iconColor: '#ffc107',        // icon vàng cảnh báo
                    customClass: {
                        popup: 'border border-warning shadow-lg'
                    }
                });

                if (data.max) {
                    qty.value = data.max;
                    updateTotal();
                }
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi kết nối',
                timer: 2000,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                background: '#ffffff',
                color: '#212529',
                iconColor: '#dc3545',
                customClass: {
                    popup: 'border border-danger shadow-lg'
                }
            });
        });
    });

    updateTotal();
});
</script>
@endpush
