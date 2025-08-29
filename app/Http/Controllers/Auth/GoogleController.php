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
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Tìm user có email tương ứng
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Cập nhật Google ID và avatar nếu user đã tồn tại
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Tạo user mới
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(16)), // Random password
                    'email_verified_at' => now(), // Google đã verify email
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
