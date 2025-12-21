{{-- resources/views/layouts/guest/slider.blade.php --}}
<section id="slider">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
               <div id="slider-carousel" class="carousel slide">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="item active">
        <div class="row">
            <div class="col-sm-6">
                <h1><span>V</span>EGETAS CART</h1>
                <h2>Thực Phẩm 100% hữu cơ</h2>
                <p>Giao tận nơi trong 2h – Sạch từ gốc!</p>
                <a href="#" class="btn btn-default get">Mua ngay</a>
            </div>
            <div class="col-sm-6">
                <img src="{{ asset('frontend/images/home/girl1.jpg') }}" class="girl img-responsive" alt="" />
            </div>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="item">
        <div class="row">
            <div class="col-sm-6">
                <h1><span>F</span>RESH DAILY</h1>
                <h2>Rau củ thu hoạch mỗi sáng</h2>
                <p>Luôn tươi mới – Chất lượng kiểm định!</p>
                <a href="#" class="btn btn-default get">Khám phá ngay</a>
            </div>
            <div class="col-sm-6">
                <img src="{{ asset('frontend/images/home/girl2.jpg') }}" class="girl img-responsive" alt="" />
            </div>
        </div>
    </div>

    <!-- Slide 3 -->
    <div class="item">
        <div class="row">
            <div class="col-sm-6">
                <h1><span>S</span>AFE FOOD</h1>
                <h2>Nói không với hoá chất</h2>
                <p>Sản phẩm đạt chuẩn VietGAP – An toàn cho mọi gia đình.</p>
                <a href="#" class="btn btn-default get">Xem sản phẩm</a>
            </div>
            <div class="col-sm-6">
                <img src="{{ asset('frontend/images/home/girl3.jpg') }}" class="girl img-responsive" alt="" />
            </div>
        </div>
    </div>

</div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next"><i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <style>
        #slider-carousel .girl {
    width: 100%;
    height: 550px;       /* hoặc 420px tùy giao diện của bạn */
    object-fit: cover;   /* giữ tỉ lệ đẹp, không méo hình */
    border-radius: 10px; /* nhìn mềm hơn (optional) */
}
</style>

</section>