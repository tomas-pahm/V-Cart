<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>V-Cart - Đăng nhập</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <style>
        :root { --heading-color:#0f2943; --accent-color:#2E7D32; }
        body { margin:0; padding:0; height:100vh; font-family:'Segoe UI',sans-serif;
               background:linear-gradient(160deg,var(--heading-color),var(--accent-color));
               display:flex; justify-content:center; align-items:center; }
        .header{position:absolute;top:20px;left:30px;z-index:1000;}
        .logo{display:flex;align-items:center;gap:8px;color:white;text-decoration:none;font-size:24px;font-weight:bold;}
        :root {
        --default-color: #0a0f14; /* Default color used for the majority of the text content across the entire website */
        --heading-color: #0f2943; /* Color for headings, subheadings and title throughout the website */
        --accent-color: #2E7D32; /* Accent color used for buttons, links and other interactive elements */ 
      }                       
          body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(160deg, var(--heading-color), var(--accent-color));
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
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

      .login-container {
        background: rgba(214, 212, 212, 0.858);
        padding: 2rem 3rem;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.76);
        text-align: center;
        width: 320px;
      }

      .login-container h2 {
        margin-bottom: 1.5rem;
        font-weight: bold;
        font-size: 24px;
        background: linear-gradient(160deg, var(--heading-color), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        color: transparent;
      }


      .login-container input {
        width: 100%;
        padding: 10px;
        margin: 0.5rem 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
      }

      .login-container button {
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

      button:hover {
          color: white;
          color: #fff;
          background: linear-gradient(160deg, var(--heading-color), var(--accent-color));
          border: 2px solid white;

      }

      input:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 10px #2E7D32;
        outline: none;
      }

      .signup-text {
        margin-top: 1rem;
        font-size: 0.9rem;
      }

      .signup-text a {
        color: #5c6bc0;
        text-decoration: none;
      }

      .sitename {
        font-family: 'Dancing Script', cursive;
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
        .sitename{font-family:'Dancing Script',cursive;}
        .logo:hover{text-shadow:0 0 10px var(--accent-color),0 0 20px var(--accent-color);transition:.3s;}
        .login-container{background:rgba(214,212,212,.858);padding:2rem 3rem;border-radius:15px;
                         box-shadow:0 4px 20px rgba(0,0,0,.76);width:320px;text-align:center;}
        .login-container h2{margin-bottom:1.5rem;font-size:24px;font-weight:bold;
            background:linear-gradient(160deg,var(--heading-color),var(--accent-color));
            -webkit-background-clip:text;-webkit-text-fill-color:transparent;}
        input{width:100%;padding:10px;margin:.5rem 0;border:1px solid #ccc;border-radius:8px;box-sizing:border-box;}
        input:focus{border-color:var(--accent-color);box-shadow:0 0 10px #2E7D32;outline:none;}
        button{margin-top:30px;width:100%;padding:12px;border-radius:55px;background:transparent;
               border:2px solid var(--accent-color);color:black;font-weight:600;cursor:pointer;transition:.3s;}
        button:hover{background:linear-gradient(160deg,var(--heading-color),var(--accent-color));color:white;border-color:white;}
        .error{background:#ffebee;color:#d32f2f;padding:10px;border-radius:5px;margin:10px 0;}
    </style>
</head>
<body>

<header class="header">
    <a href="{{ url('/') }}" class="logo">
        <h1 class="sitename">Vegetas</h1>
        <span class="sitename" style="font-size:20px;">𓂃Cart𓂃⁠♡</span>
    </a>
</header>

<div class="login-container">
    <h2>Đăng nhập</h2>

    @if($errors->any())
        <div class="error">Warning {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">ĐĂNG NHẬP</button>
    </form>

    <p style="margin-top:1rem;font-size:0.9rem;">
        Chưa có tài khoản? 
        <a href="{{ route('register') }}" style="color:#2E7D32;font-weight:600;">Đăng ký ngay</a>
    </p>
</div>
</body>
</html>