{{-- resources/views/layouts/navigation.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vegetas 𓂃Cart𓂃⁠♡</title>
    <link rel="icon" href="{{ asset('frontend/images/ico/favicon.jpg') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

    <style>
        :root{--heading:#0f2943;--accent:#2E7D32}
        body{margin:0;padding:0;min-height:100vh;font-family:'Segoe UI',sans-serif;
             background:linear-gradient(160deg,var(--heading),var(--accent));
             display:flex;justify-content:center;align-items:center;position:relative;}

        .header-logo{position:absolute;top:20px;left:30px;z-index:10;}
        .logo{display:flex;align-items:center;gap:8px;color:white;text-decoration:none;font-size:28px;font-weight:bold;}
        .logo:hover{text-shadow:0 0 15px var(--accent),0 0 30px var(--accent);transition:.4s;}
        .sitename{font-family:'Dancing Script',cursive;}

        .nav-box{
            background:rgba(214,212,212,.92);
            backdrop-filter:blur(12px);
            padding:2.5rem 3rem;
            border-radius:20px;
            box-shadow:0 10px 40px rgba(0,0,0,.6);
            width:380px;max-width:90%;
            text-align:center;
        }
        .nav-box h2{
            margin:0 0 1.8rem;
            font-size:28px;font-weight:bold;
            background:linear-gradient(160deg,var(--heading),var(--accent));
            -webkit-background-clip:text;background-clip:text;
            -webkit-text-fill-color:transparent;
        }
        .dashboard-btn{
            display:inline-block;padding:14px 30px;background:white;color:#333;
            border-radius:50px;font-weight:600;text-decoration:none;
            box-shadow:0 4px 15px rgba(0,0,0,.15);transition:.3s;margin-bottom:2rem;
        }
        .dashboard-btn:hover{background:var(--accent);color:white;transform:translateY(-3px);}

        .user-info{margin:1.5rem 0;color:#333;}
        .user-name{font-size:1.4rem;font-weight:600;color:var(--heading);}
        .user-email{font-size:0.95rem;color:#555;margin-top:4px;}

        .actions a, .actions button{
            display:block;width:100%;padding:14px;margin:10px 0;
            border-radius:12px;font-weight:600;transition:.3s;cursor:pointer;
        }
        .btn-profile{background:#f8f9fa;color:#333;border:2px solid #ddd;}
        .btn-profile:hover{background:var(--accent);color:white;border-color:var(--accent);}

        .btn-logout{background:#d32f2f;color:white;border:none;}
        .btn-logout:hover{background:#b71c1c;}
    </style>
</head>
<body>

    <!-- Logo góc trái trên -->
    <div class="header-logo">
        <a href="{{ route('dashboard') }}" class="logo">
            <span class="sitename">Vegetas</span>
            <span class="sitename" style="font-size:20px;">𓂃Cart𓂃⁠♡</span>
        </a>
    </div>

    <!-- Hộp menu chính giữa -->
    <div class="nav-box">
        <h2>Chào mừng trở lại!</h2>

        <a href="{{ route('dashboard') }}" class="dashboard-btn">
            Trang chủ Dashboard
        </a>

        <div class="user-info">
            <div class="user-name">{{ Auth::user()->name }}</div>
            <div class="user-email">{{ Auth::user()->email }}</div>
        </div>

        <div class="actions">
            <a href="{{ route('profile.edit') }}" class="btn-profile">
                Hồ sơ cá nhân
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</body>
</html>