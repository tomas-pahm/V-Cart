<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-Cart - Đăng nhập</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/images/ico/favicon.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/auth.css') }}">
</head>
<body>

<header class="header">
    <a href="{{ url('/') }}" class="logo">
        <h1 class="sitename">Vegetas</h1>
        <span class="sitename" style="font-size:20px;">𓂃Cart𓂃⁠♡</span>
    </a>
</header>

<div class="auth-container">
    <h2>Đăng nhập</h2>

    @if($errors->any())
        <div class="error">Warning {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">ĐĂNG NHẬP</button>

        <div class="divider">
    <span>HOẶC</span>
</div>

<a href="{{ route('auth.google') }}" class="google-auth-btn">
    <img src="https://www.svgrepo.com/show/355037/google.svg" width="20px">
    <span>Tiếp tục với Google</span>
</a>

    </form>

    <p style="margin-top:1rem;font-size:0.9rem;">
        Chưa có tài khoản? 
        <a href="{{ route('register') }}" style="color:#2E7D32;font-weight:600;">Đăng ký ngay</a>
    </p>
</div>
</body>
</html>