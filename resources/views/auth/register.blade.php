<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-Cart - Đăng ký tài khoản</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/images/ico/favicon.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}">
</head>
<body>

<header class="header">
    <a href="{{ url('/') }}" class="logo">
        <h1 class="sitename">Vegetas</h1>
        <span class="sitename" style="font-size: 20px;">𓂃Cart𓂃⁠♡</span>
    </a>
</header>

<div class="auth-container">
    <h2>Đăng ký</h2>

    @if(session('success'))
        <div class="success">Success {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="error">Warning {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="name" placeholder="Tên người dùng" value="{{ old('name') }}" required>
        <input type="text" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}" required>
        <input type="text" name="address" placeholder="Địa chỉ" value="{{ old('address') }}" required>
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
        <button type="submit">TẠO TÀI KHOẢN</button>

        <div class="divider">
    <span>HOẶC</span>
</div>

<a href="{{ route('auth.google') }}" class="google-auth-btn">
    <img src="https://www.svgrepo.com/show/355037/google.svg" width="20px">
    <span>Tiếp tục với Google</span>
</a>

    </form>

    <p style="margin-top:1rem;font-size:0.9rem;">
        Đã có tài khoản? 
        <a href="{{ route('login') }}" style="color:#2E7D32;font-weight:600;">Đăng nhập ngay</a>
    </p>
</div>

</body>
</html>