@extends('layouts.app')

@section('title', 'Truy cập bị từ chối - 403')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- 403 Illustration -->
        <div class="relative mb-8">
            <div class="text-9xl font-bold text-yellow-200 dark:text-yellow-300 select-none animate-pulse">403</div>
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

        <!-- Permission Info -->
        <div class="bg-gradient-to-br from-yellow-50 dark:from-yellow-900 to-yellow-100 dark:to-yellow-800 rounded-2xl p-6 mb-8 animate-slide-up" style="animation-delay: 0.4s">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-yellow-900 dark:text-yellow-100">Thông tin quyền truy cập</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl p-6 text-left">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-red-900 dark:text-red-100">Không được phép</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-red-700 dark:text-red-300">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Truy cập nội dung này
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Thực hiện hành động này
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Xem thông tin nhạy cảm
                        </li>
                    </ul>
                </div>
                
                <div class="bg-white rounded-xl p-6 text-left">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-400-dark">Được phép</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-primary-700 dark:text-primary-300-dark">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Xem nội dung công khai
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Đăng nhập/đăng ký
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Liên hệ hỗ trợ
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-12 animate-slide-up" style="animation-delay: 0.6s">
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
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-200 dark:border-gray-700 p-8 mb-8 animate-slide-up" style="animation-delay: 0.8s">
            <div class="flex items-center justify-center mb-6">
                <svg class="w-6 h-6 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-secondary-900 dark:text-primary-400-dark">Cần trợ giúp?</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark mb-2">Xem hướng dẫn</h3>
                    <p class="text-secondary-600 dark:text-gray-300 text-sm mb-4">Tìm hiểu về phân quyền và cách sử dụng</p>
                    <a href="/help" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-sm">
                        Xem hướng dẫn →
                    </a>
                </div>
            </div>
        </div>

        <!-- Current User Info -->
        @auth
        <div class="bg-gradient-to-br from-secondary-50 dark:from-gray-800 to-secondary-100 dark:to-gray-700 rounded-xl p-6 animate-fade-in" style="animation-delay: 1s">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const lockIcon = document.querySelector('.animate-bounce');
    if (lockIcon) {
        setInterval(() => {
            lockIcon.style.transform = 'scale(1.1)';
            setTimeout(() => {
                lockIcon.style.transform = 'scale(1)';
            }, 200);
        }, 3000);
    }
    
    const permissionCheck = document.createElement('div');
    permissionCheck.className = 'fixed top-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg shadow-lg max-w-sm transform translate-x-full transition-transform duration-500';
    permissionCheck.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="text-sm">
                <div class="font-medium">Quyền truy cập bị hạn chế</div>
                <div>Tài khoản của bạn không có quyền truy cập trang này.</div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-yellow-600 hover:text-yellow-800">×</button>
        </div>
    `;
    document.body.appendChild(permissionCheck);
    
    setTimeout(() => {
        permissionCheck.style.transform = 'translateX(0)';
    }, 1000);
    
    setTimeout(() => {
        permissionCheck.style.transform = 'translateX(full)';
        setTimeout(() => {
            if (permissionCheck.parentElement) {
                permissionCheck.remove();
            }
        }, 500);
    }, 8000);
});
</script>
@endsection
