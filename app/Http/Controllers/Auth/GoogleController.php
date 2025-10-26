<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Chuyển hướng đến OAuth của Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Xử lý callback OAuth của Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Tìm người dùng với email khớp
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Cập nhật Google ID và avatar nếu người dùng đã tồn tại
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => $user->email_verified_at ?? now(), // Verify email if not verified
                ]);
            } else {
                // Tạo người dùng mới
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(16)), // Mật khẩu ngẫu nhiên
                    'email_verified_at' => now(), // Google đã xác thực email
                    'role' => 'user',
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Có lỗi xảy ra khi đăng nhập với Google.']);
        }
    }
}
