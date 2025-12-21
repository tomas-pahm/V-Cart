<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vegetas Cart – Thực Phẩm Hữu Cơ</title>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- CSS của bạn -->
    @vite('resources/css/app.css')

    <!-- hoặc -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->

    <!-- Nếu muốn dùng Alpine.js (không liên quan Livewire) thì để lại, không thì xóa luôn -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">

    <div class="min-h-screen flex flex-col">
        

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Nội dung chính -->
        <main class="flex-1">
    @yield('content')
</main>


        <!-- Footer nếu có -->
        @includeWhen(View::exists('layouts.footer'), 'layouts.footer')
    </div>

    <!-- SweetAlert2 (giữ lại nếu bạn vẫn muốn dùng toast) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Các script khác của bạn (nếu có) -->
    @vite('resources/js/app.js')
<script>
    $('.add-to-cart-form').on('submit', function(e) {
    e.preventDefault(); // ngăn submit mặc định
    let form = $(this);

    $.post(form.attr('action'), form.serialize())
        .done(function(res) {
            // Cập nhật cart count
            $('#cart-count').text(res.cartCount);
        });
});
</script>
</body>
</html>