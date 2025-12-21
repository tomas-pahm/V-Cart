{{-- resources/views/partials/_recommended-carousel.blade.php --}}
<div class="carousel-inner">
    @php
        $recommended = $products->shuffle()->take(12);
        $chunks = $recommended->chunk(4);
    @endphp

    @foreach($chunks as $index => $group)
        <div class="item {{ $index == 0 ? 'active' : '' }}">
            <div class="row">
                @foreach($group as $product)
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{ asset('frontend/images/sanpham/' . $product->images[0]) }}" 
                                     alt="{{ $product->name }}" 
                                     style="height:180px; object-fit:cover;">
                                <h2>{{ number_format($product->price) }}đ</h2>
                                <p>{{ $product->name }}</p>
                                <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Thêm vào giỏ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<!-- NÚT PREV/NEXT -->
<a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
    <i class="fa fa-angle-left"></i>
</a>
<a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
    <i class="fa fa-angle-right"></i>
</a>