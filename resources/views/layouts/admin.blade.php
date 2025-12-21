<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') - Vegetas Admin</title>
    <link rel="icon" href="{{ asset('frontend/images/ico/favicon.jpg') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

     <link href="{{ asset('frontend/css/admin/main.css') }}" rel="stylesheet">

</head>

<body>

    <!-- Nút menu mobile -->
    <div class="menu-toggle lg:hidden" onclick="document.querySelector('.sidebar').classList.toggle('active')">
        ☰
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <a href="{{ route('admin.dashboard') }}" class="logo">
            <span class="sitename">Vegetas</span>
            <span class="sitename" style="font-size:20px;">𓂃Cart𓂃⁠♡</span>
        </a>

        <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('admin.products.index') }}">🥬 Sản phẩm</a>
        <a href="{{ route('admin.categories.index') }}">📂 Danh mục</a>
        <a href="{{ route('admin.orders.index') }}">📦 Đơn hàng</a>
        <a href="{{ route('admin.users.index') }}">👤 Người dùng</a>
        <a href="{{ route('admin.posts.index') }}">📝 Bài viết</a>

        <a href="{{ route('profile.edit') }}" 
   class="flex items-center justify-center gap-2 w-full bg-blue-500 hover:bg-blue-600 px-4 py-2 
          rounded-lg text-white font-semibold mt-3">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M5.121 17.804A4 4 0 0112 15m6.879 2.804A4 4 0 0012 15m0 0a4 4 0 110-8 4 4 0 010 8z" />
    </svg>
    Hồ sơ cá nhân
</a>


        <form method="POST" action="{{ route('logout') }}" class="mt-6">
            @csrf
            <button class="w-full bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-white font-semibold">
                Đăng xuất
            </button>
        </form>

    </div>

    <!-- MAIN -->
    <div class="main-content">
        <h2 class="page-title">@yield('title')</h2>
        @yield('content')
    </div>

</body>
</html>
