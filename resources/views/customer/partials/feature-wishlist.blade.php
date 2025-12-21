<div class="features_items">
    <h2 class="title text-center text-success">
        Sản phẩm yêu thích của tôi
    </h2>

    <div class="row">
        @foreach(auth()->user()->wishlistProducts as $product)
        <div class="col-6 col-sm-4 mb-4">
            <div class="product-image-wrapper position-relative overflow-hidden rounded shadow-sm">
                <div class="single-products">
                    <div class="productinfo text-center position-relative">
                        <img src="{{ asset('frontend/images/sanpham/' . $product->images[0]) }}"
                             alt="{{ $product->name }}"
                             class="img-fluid w-100"
                             style="height: 260px; object-fit: cover; border-radius: 12px; transition: transform 0.4s ease;">

                        {{-- Nút toggle wishlist --}}
                        <button class="wishlist-btn position-absolute top-0 start-0 m-2 border-0 bg-transparent" 
                                style="z-index:10; font-size:1.5rem; color:red;">
                            ❤️
                        </button>

                        <div class="mt-3">
                            <h2 class="text-success fs-5 mb-1">
                                {{ number_format($product->price) }}đ 
                                <small class="text-muted">/ 100g</small>
                            </h2>
                            <p class="fw-bold text-dark mb-2" style="font-size:1.1rem;">{{ $product->name }}</p>

                            <form action="{{ route('cart.add', $product->product_id) }}" method="POST" class="add-to-cart-form d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm px-4">
                                    Thêm vào giỏ
                                </button>
                            </form>

                            <p class="text-muted small mt-1">
                                ({{ number_format($product->price * 10) }}đ/kg)
                            </p>
                        </div>
                    </div>

                    <!-- Overlay -->
                    <div class="product-overlay position-relative">

                                       <!-- Nút wishlist đẹp hơn, bo tròn, có hiệu ứng -->
<button class="wishlist-btn btn p-0 border-0 bg-transparent position-absolute d-flex align-items-center justify-content-center"
        data-product-id="{{ $product->product_id }}"
        style="top: 12px; left: 12px; width: 44px; height: 44px; z-index: 20; border-radius: 50%; background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
    <span class="heart-icon fs-4">
        @if(auth()->user() && auth()->user()->wishlists->contains('product_id', $product->product_id))
            ❤️
        @else
            🤍
        @endif
    </span>
</button>
                      
                        <div class="overlay-content position-absolute top-50 start-50 translate-middle text-center w-100 px-3">
                            <h2 class="text-white mb-2 fw-bold">{{ number_format($product->price) }}đ / 100g</h2>
                            <p class="text-white fw-bold fs-5 mb-3">{{ $product->name }}</p>
                            <p class="text-warning small mb-4">{!! nl2br(e(Str::limit($product->description, 120))) !!}</p>

                            <div class="overlay-buttons">
                                <form action="{{ route('product.detail', $product->product_id) }}" method="GET" class="d-inline">
                                    <button type="submit" class="btn btn-view">Xem chi tiết</button>
                                </form>
                                <form action="{{ route('cart.add', $product->product_id) }}" method="POST" class="add-to-cart-form d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-cart">Thêm vào giỏ</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- AJAX toggle wishlist --}}
<script>
document.querySelectorAll('.wishlist-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const card = this.closest('.product-image-wrapper');
        const productId = @json($product->product_id);

        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'removed') {
                card.remove(); // remove khỏi view nếu đã bỏ yêu thích
            }
        });
    });
});
</script>
