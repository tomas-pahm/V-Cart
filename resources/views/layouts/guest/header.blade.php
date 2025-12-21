<header id="header">
    <!--header_top-->
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><i class="fa fa-phone"></i> 1900 1234</li>
                            <li><i class="fa fa-envelope"></i> hello@vegetascart.vn</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--header-middle-->
    <div class="header-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{ url('/') }}">
                            <h1 style="margin:0; color:#2E7D32; font-family:'Dancing Script',cursive; font-size:36px;">
                                Vegetas<span style="color:#1b5e20; font-size:24px;">Cart</span>
                            </h1>
                        </a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">

                            @auth
                                <li><a href="{{ route('profile.edit') }}"><i class="fa fa-user"></i> {{ auth()->user()->name }}</a></li>
                                <li class="position-relative">
    <a href="{{ route('wishlist.index') }}" id="wishlist-link">
        <i class="fa fa-star"></i> Yêu thích
        @if(auth()->check() && auth()->user()->wishlists->count() > 0)
            <span id="wishlist-count" class="badge" style="position:absolute; top:-8px; right:-8px; background:#FE980F; font-size:10px; padding:2px 6px; border-radius:50%;">
                {{ auth()->user()->wishlists->count() }}
            </span>
        @endif
    </a>
</li>



                                {{-- Cart counter --}}
                                @php
                                    $cartCount = 0;
                                    if (Auth::check()) {
                                        $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                                    } else {
                                        foreach (session('cart', []) as $item) {
                                            $cartCount += $item['quantity'] ?? 0;
                                        }
                                    }
                                @endphp
                                <li class="position-relative">
                                    <a href="{{ route('cart.index') }}">
                                        <i class="fa fa-shopping-cart"></i> Giỏ hàng
                                        <span id="cart-count" class="badge" style="position:absolute; top:-8px; right:-8px; background:#FE980F; font-size:10px; padding:2px 6px; border-radius:50%;">
                                            {{ $cartCount }}
                                        </span>
                                    </a>
                                </li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-link logout-link"
        style="color:inherit; text-decoration:none; padding:0; margin:0;">
    <i class="fa fa-lock"></i> Đăng xuất
</button>
                                    </form>
                                </li>
                            @else
                                <li><a href="{{ route('login') }}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                <li><a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
                            @endauth

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--header-bottom-->
    <div class="header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Trang chủ</a></li>
                            <li><a href="#">Sản phẩm</a></li>
                            <li><a href="#">Khuyến mãi</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="{{ route('payments.index') }}" class="{{ Request::is('payments*') ? 'active' : '' }}">Hóa Đơn</a></li>
                            <li><a href="{{ route('cart.history') }}" class="nav-link">Lịch sử giỏ hàng</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
    <form action="{{ route('products.search') }}" method="GET" class="d-flex">
        <input type="text" name="query" placeholder="Tìm kiếm rau sạch..." class="form-control" value="{{ request('query') }}">
    </form>
</div>

                </div>
            </div>
        </div>
    </div>
</header>


