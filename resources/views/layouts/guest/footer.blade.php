{{-- resources/views/layouts/guest/footer.blade.php --}}
<footer id="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="companyinfo">
                        <h2><span style="color:#FE980F">V</span>egetas Cart</h2>
                        <p>Thực Phẩm Hữu Cơ mỗi ngày – Từ nông trại đến bàn ăn</p>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#"><div class="iframe-img"><img src="{{ asset('frontend/images/home/iframe1.png') }}" alt="" /></div></a>
                                <p>Nông trại Đà Lạt</p>
                            </div>
                        </div>
                        <!-- giữ nguyên 3 cái kia nếu có -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-widget">
        <div class="container">
            <div class="row">

                <!-- Chỉ thêm class text-center + mt-4 để các cột đều và đẹp hơn -->
                <div class="col-sm-2 text-center">
                    <div class="single-widget">
                        <h2>Dịch vụ</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Hỗ trợ</a></li>
                            <li><a href="#">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="single-widget">
                        <h2>Sản phẩm</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Rau củ</a></li>
                            <li><a href="#">Trái cây</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="single-widget">
                        <h2>Chính sách</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Đổi trả</a></li>
                            <li><a href="#">Bảo mật</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Chỉ thêm mt-4 để form không bị dính vào trên -->
                <div class="col-sm-3 col-sm-offset-1 mt-4">
                    <div class="single-widget">
                        <h2>Nhận tin khuyến mãi</h2>
                        <form class="searchform">
                            <input type="text" placeholder="Email của bạn...">
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
    <div class="container">
        <div class="text-center py-3">
            <small class="text-muted">
                Copyright © 2025 Vegetas Cart. All rights reserved.
                &nbsp;&nbsp;|&nbsp;&nbsp;
                Made with <i class="fa fa-heart text-danger"></i> by Thomas Phạm
            </small>
        </div>
    </div>
</div>

</footer>