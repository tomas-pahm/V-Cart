{{-- resources/views/profile/edit.blade.php --}}
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ - Vegetas Cart</title>
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

        .profile-container{
            background:rgba(214,212,212,.92);
            backdrop-filter:blur(12px);
            padding:2.5rem 3rem;
            border-radius:20px;
            box-shadow:0 10px 40px rgba(0,0,0,.6);
            width:420px;max-width:92%;
            text-align:center;
        }
        .profile-container h2{
            margin:0 0 2rem;font-size:28px;font-weight:bold;
            background:linear-gradient(160deg,var(--heading),var(--accent));
            -webkit-background-clip:text;background-clip:text;
            -webkit-text-fill-color:transparent;
        }
        .back-btn{
            position:absolute;top:20px;right:30px;color:white;font-size:14px;text-decoration:none;
            background:rgba(255,255,255,.2);padding:8px 16px;border-radius:50px;
            backdrop-filter:blur(5px);
        }
        .back-btn:hover{background:var(--accent);}
    </style>
</head>
<body>

    <div class="header-logo">
        <a href="{{ route('dashboard') }}" class="logo">
            <span class="sitename">Vegetas</span>
            <span class="sitename" style="font-size:20px;">𓂃Cart𓂃⁠♡</span>
        </a>
    </div>


    <a href="{{ route('dashboard') }}" class="back-btn">
        ← Quay lại Dashboard
    </a>

    <div class="profile-container">
        <h2>Hồ sơ cá nhân</h2>

        <!-- 1. Cập nhật thông tin -->
        <div class="text-left mb-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- 2. Đổi mật khẩu -->
        <div class="text-left mb-8 border-t pt-8 border-gray-300">
            @include('profile.partials.update-password-form')
        </div>

        <!-- 3. Xóa tài khoản -->
        <div class="text-left border-t pt-8 border-gray-300">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</body>
</html>