<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Route;

// Các route xác thực cho người dùng chưa đăng nhập
Route::middleware('guest')->group(function () {
    // Đăng nhập: hiển thị form và xử lý yêu cầu đăng nhập
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Đăng ký: hiển thị form và xử lý yêu cầu đăng ký tài khoản mới
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    // Đặt lại mật khẩu: gửi link reset và xử lý cập nhật mật khẩu mới
    Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.store');
});

// Các route xác thực cho người dùng đã đăng nhập
Route::middleware('auth')->group(function () {
    // Đăng xuất: xóa phiên làm việc của người dùng
    Route::post('logout', [LogoutController::class, 'logout'])->name('logout');

    // Xác minh email: hiển thị thông báo, xác minh qua link và gửi lại email
    Route::get('email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');

    Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');

    // Giới hạn tần suất gửi lại email xác minh (6 lần/1 phút)
    Route::post('email/resend', [EmailVerificationController::class, 'resend'])
        ->middleware(['throttle:6,1'])
        ->name('verification.resend');
});
