<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Mặc định là user
        ]);

        // Đăng nhập user để có thể gửi email verification
        Auth::login($user);

        // Gửi email verification
        $user->sendEmailVerificationNotification();

        // Chuyển hướng đến trang yêu cầu verify email
        return redirect()->route('verification.notice')
            ->with('message', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
    }
}
