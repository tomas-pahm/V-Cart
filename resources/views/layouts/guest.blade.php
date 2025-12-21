{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vegetas Cart - Thực Phẩm Hữu Cơ')</title>

    
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/shop.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('frontend/images/ico/favicon.jpg') }}">

   

</head>
<body>

    @include('layouts.guest.header')

@if(Request::is('/') || Request::is('dashboard'))
    @include('layouts.guest.slider')
@endif



    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('layouts.guest.sidebar')
                </div>
                <div class="col-sm-9 padding-right">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    @include('layouts.guest.footer')

    <!-- JS ĐÚNG THỨ TỰ -->
    <script src="{{ asset('frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.csrfToken = '{{ csrf_token() }}';
    window.wishlistToggleUrl = '{{ route('wishlist.toggle') }}';
    window.sessionSuccess = @json(session('success'));
    window.sessionError = @json(session('error'));
</script>

<script src="{{ asset('frontend/js/shop.js') }}"></script>

@stack('scripts')
@stack('styles')



</body>
</html>