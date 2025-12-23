<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Chuyển hướng người dùng đến trang đăng nhập của Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Xử lý dữ liệu trả về từ Google
     */
    public function handleGoogleCallback()
    {
        try {
            // Lấy thông tin user từ Google
            $googleUser = Socialite::driver('google')->user();

            
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                
                if (empty($user->google_id)) {
                    $user->update(['google_id' => $googleUser->id]);
                }
                
                Auth::login($user);
            } else {
                
                $newUser = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => Hash::make(Str::random(16)), 
                    'role_id'   => 1,          
                    'phone'     => '',         
                    'address'   => '',         
                ]);

                Auth::login($newUser);
            }

            
            return redirect()->intended('/')->with('success', 'Đăng nhập bằng Google thành công!');

        } catch (Exception $e) {
            
            return redirect('/login')->with('error', 'Có lỗi xảy ra khi đăng nhập bằng Google: ' . $e->getMessage());
        }
    }
}