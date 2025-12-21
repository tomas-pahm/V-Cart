<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password'         => ['required', 'confirmed', Password::defaults()],
            ], [
                'current_password.current_password' => 'Mật khẩu hiện tại không đúng!',
                'password.confirmed'                => 'Xác nhận mật khẩu không khớp!',
            ]);
        } catch (ValidationException $e) {
            // Nếu là AJAX → trả JSON lỗi chi tiết
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors'  => $e->errors()
                ], 422);
            }
            throw $e; // fallback cho form bình thường
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Thành công → trả JSON cho AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đổi mật khẩu thành công!'
            ]);
        }

        return back()->with('status', 'password-updated');
    }
}