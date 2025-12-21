<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        // Cho phép Admin (2) và Super Admin (3)
        if (Auth::check() && in_array(Auth::user()->role_id, [2, 3])) {
            return $next($request);
        }

        return redirect('/')
            ->with('error', 'Bạn không có quyền truy cập trang quản trị!');
    }
}
