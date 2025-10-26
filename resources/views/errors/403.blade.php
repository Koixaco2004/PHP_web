@extends('layouts.app')

@section('title', 'Truy cập bị từ chối - 403')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- 403 Illustration -->
        <div class="relative mb-8 animate-bounce">
            <div class="text-9xl font-bold text-primary-900 dark:text-primary-300 select-none">403</div>
        </div>

        <!-- Error Message -->
        <div class="animate-fade-in" style="animation-delay: 0.2s">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark mb-4">
                Truy cập bị từ chối
            </h1>
            <p class="text-xl text-secondary-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                Bạn không có quyền truy cập vào trang này. Vui lòng đăng nhập với tài khoản
                có đủ quyền hạn hoặc liên hệ quản trị viên.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-12 animate-slide-up" style="animation-delay: 0.4s">
            @guest
                <a href="{{ route('login') }}" class="btn-primary inline-flex items-center px-8 py-4 text-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Đăng nhập
                </a>
            @else
                <button onclick="history.back()" class="btn-primary inline-flex items-center px-8 py-4 text-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Quay lại
                </button>
            @endguest

            <a href="{{ route('home') }}" class="btn-secondary inline-flex items-center px-8 py-4 text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Về trang chủ
            </a>
        </div>

        <!-- Help Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-200 dark:border-gray-700 p-8 mb-12 animate-slide-up" style="animation-delay: 0.6s">
            <div class="flex items-center justify-center mb-6">
                <svg class="w-6 h-6 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-secondary-900 dark:text-primary-400-dark">Cần trợ giúp?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @guest
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark mb-2">Tạo tài khoản</h3>
                    <p class="text-secondary-600 dark:text-gray-300 text-sm mb-4">Đăng ký để có thể truy cập nhiều nội dung hơn</p>
                    <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm">
                        Đăng ký ngay →
                    </a>
                </div>
                @endguest

                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900-dark rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark mb-2">Liên hệ quản trị</h3>
                    <p class="text-secondary-600 dark:text-gray-300 text-sm mb-4">Yêu cầu cấp quyền truy cập từ quản trị viên</p>
                    <a href="mailto:admin@example.com" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium text-sm">
                        Gửi email →
                    </a>
                </div>
            </div>
        </div>

        <!-- Current User Info -->
        @auth
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-200 dark:border-gray-700 p-8 animate-fade-in" style="animation-delay: 0.8s">
            <div class="flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-secondary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Thông tin tài khoản hiện tại</h3>
            </div>
            <div class="text-center text-sm text-secondary-700 dark:text-gray-300">
                <p class="mb-1">Đang đăng nhập với tên: <span class="font-medium">{{ Auth::user()->name }}</span></p>
                <p class="mb-1">Email: <span class="font-medium">{{ Auth::user()->email }}</span></p>
                <p>Quyền hạn: <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-200 dark:bg-gray-700 text-secondary-800 dark:text-gray-200">
                    {{ Auth::user()->role ?? 'Thành viên' }}
                </span></p>
            </div>
        </div>
        @endauth
    </div>
</div>
@endsection
