<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-Cart - Đăng ký tài khoản</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend/images/ico/favicon.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <style>
        :root { --default-color:#0a0f14; --heading-color:#0f2943; --accent-color:#2E7D32; }
        body { margin:0; padding:0; height:100vh; font-family:'Segoe UI',sans-serif;
               background:linear-gradient(160deg,var(--heading-color),var(--accent-color));
               display:flex; justify-content:center; align-items:center; }
:root {
  --default-color: #0a0f14;
  --heading-color: #0f2943;
  --accent-color: #2E7D32;
}

html, body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(160deg, var(--heading-color), var(--accent-color));
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}


.header {
  position: absolute;
  top: 20px;
  left: 30px;
  color: white;
  font-size: 24px;
  font-weight: bold;
  display: flex;
  align-items: center;
  gap: 8px;
  z-index: 1000;
}
.header span {
  font-size: 16px;
  font-weight: normal;
  color: #cde6ff;
}

.signup-container {
  background: rgba(214, 212, 212, 0.858);
  padding: 2rem 3rem;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.76);
  text-align: center;
  width: 320px;
}

.signup-container h2 {
  margin-bottom: 1.5rem;
  font-weight: bold;
  font-size: 24px;
  background: linear-gradient(160deg, var(--heading-color), var(--accent-color));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  color: transparent;
}

.signup-container input {
  width: 100%;
  padding: 10px;
  margin: 0.5rem 0;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-sizing: border-box;
}

.signup-container button {
  margin-top: 30px;
  border-radius: 55px;
  color: black;
  background: transparent;
  padding: 10px 0;
  width: 100%;
  border: 2px solid var(--accent-color);
  transition: all 0.3s;
  font-weight: 600;
}

.signup-container button:hover {
  color: white;
  background: linear-gradient(160deg, var(--heading-color), var(--accent-color));
  border: 2px solid white;
}

input:focus {
  border-color: var(--accent-color);
  box-shadow: 0 0 10px #2E7D32;
  outline: none;
}

.login-text {
  margin-top: 1rem;
  font-size: 0.9rem;
}

.login-text a {
  color: #5c6bc0;
  text-decoration: none;
}

.sitename {
   font-family: 'Dancing Script', cursive;
}

.sitetagline {
  font-family: 'Segoe UI', sans-serif;
  font-size: 16px;
  color: #2E7D32;
  font-weight: 400;
  margin-left: 5px;
  display: inline-block;
}


.header {
  width: 100%;
  background: transparent;
  box-shadow: none;
  padding: 20px 40px;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1000;
}

.logo {
  display: flex;
  align-items: center;
  font-size: 24px;
  font-weight: bold;
  color: white;
  text-decoration: none;
}

.logo:hover {
  text-shadow: 0 0 8px var(--accent-color);
  transition: text-shadow 0.3s ease-in-out;
  cursor: pointer;
  text-shadow: 0 0 10px var(--accent-color), 0 0 20px var(--accent-color);
}

        .header { position:absolute; top:20px; left:30px; z-index:1000; }
        .logo { display:flex; align-items:center; gap:8px; color:white; text-decoration:none; font-size:24px; font-weight:bold; }
        .sitename { font-family:'Dancing Script', cursive; }
        .logo:hover { text-shadow:0 0 10px var(--accent-color), 0 0 20px var(--accent-color); transition:0.3s; }
        .signup-container { background:rgba(214,212,212,0.858); padding:2rem 3rem; border-radius:15px;
                            box-shadow:0 4px 20px rgba(0,0,0,0.76); width:320px; text-align:center; }
        .signup-container h2 { margin-bottom:1.5rem; font-weight:bold; font-size:24px;
            background:linear-gradient(160deg,var(--heading-color),var(--accent-color));
            -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        input { width:100%; padding:10px; margin:0.5rem 0; border:1px solid #ccc; border-radius:8px; box-sizing:border-box; }
        input:focus { border-color:var(--accent-color); box-shadow:0 0 10px #2E7D32; outline:none; }
        button { margin-top:30px; width:100%; padding:10px 0; border-radius:55px; background:transparent;
                 border:2px solid var(--accent-color); color:black; font-weight:600; cursor:pointer; transition:0.3s; }
        button:hover { background:linear-gradient(160deg,var(--heading-color),var(--accent-color));
                       color:white; border-color:white; }
        .error { color:#d32f2f; background:#ffebee; padding:10px; border-radius:5px; margin:10px 0; }
        .success { color:#2e7d32; background:#e8f5e9; padding:10px; border-radius:5px; margin:10px 0; }
    </style>
</head>
<body>

<header class="header">
    <a href="{{ url('/') }}" class="logo">
        <h1 class="sitename">Vegetas</h1>
        <span class="sitename" style="font-size: 20px;">𓂃Cart𓂃⁠♡</span>
    </a>
</header>

<div class="signup-container">
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
    </form>

    <p style="margin-top:1rem;font-size:0.9rem;">
        Đã có tài khoản? 
        <a href="{{ route('login') }}" style="color:#2E7D32;font-weight:600;">Đăng nhập ngay</a>
    </p>
</div>

</body>
</html>