@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-secondary-50 via-white to-primary-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 animate-fade-in">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-secondary-600 to-secondary-700 dark:from-secondary-100-dark dark:to-secondary-200-dark rounded-2xl flex items-center justify-center shadow-lg animate-bounce-subtle">
                <svg class="h-10 w-10 text-white dark:text-secondary-900-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.255 3M5 10a2 2 0 012-2m6 4a2 2 0 100-4m0 4a2 2 0 100 4m0-4v8a2 2 0 002 2h8a2 2 0 002-2v-8m0 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v1"/>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-heading font-bold text-secondary-900 dark:text-primary-100-dark">Quên mật khẩu?</h2>
            <p class="mt-2 text-sm text-secondary-600 dark:text-gray-300">Không sao! Chúng tôi sẽ gửi link đặt lại mật khẩu cho bạn</p>
        </div>

        <!-- Status Message -->
        @if (session('status'))
            <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4 animate-slide-up">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 dark:text-green-200">{{ session('status') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Reset Password Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-100 dark:border-gray-700 p-8 animate-slide-up" style="animation-delay: 0.1s">
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                        Địa chỉ email của bạn
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input type="email" 
                               class="block w-full pl-10 pr-3 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-secondary-500 focus:border-secondary-500 dark:focus:ring-secondary-400-dark dark:focus:border-secondary-400-dark bg-white dark:bg-gray-700 dark:text-primary-100-dark dark:placeholder-gray-400 transition-colors duration-200 @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 bg-red-50 dark:bg-red-900/20 @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Nhập địa chỉ email đã đăng ký"
                               required
                               autofocus>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-secondary-500 dark:text-gray-400">Chúng tôi sẽ gửi link đặt lại mật khẩu đến email này</p>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-secondary-600 to-secondary-700 dark:from-secondary-100-dark dark:to-secondary-200-dark hover:from-secondary-700 hover:to-secondary-800 dark:hover:from-secondary-200-dark dark:hover:to-secondary-300-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 dark:focus:ring-secondary-400-dark transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-secondary-200 dark:text-secondary-700-dark group-hover:text-secondary-100 dark:group-hover:text-secondary-600-dark transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </span>
                        Gửi link đặt lại mật khẩu
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-100 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.2s">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-100-dark mb-3">Cần hỗ trợ thêm?</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-center text-secondary-600 dark:text-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Kiểm tra thư mục spam/junk
                    </div>
                    <div class="flex items-center justify-center text-secondary-600 dark:text-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Link có hiệu lực trong 60 phút
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-secondary-600 dark:text-gray-400 hover:text-secondary-700 dark:hover:text-gray-300 font-medium transition-colors duration-200">
                            Liên hệ hỗ trợ kỹ thuật
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center animate-slide-up" style="animation-delay: 0.3s">
            <p class="text-sm text-secondary-600 dark:text-gray-300">
                Nhớ lại mật khẩu? 
                <a href="{{ route('login') }}" class="text-secondary-600 dark:text-secondary-400-dark hover:text-secondary-700 dark:hover:text-secondary-300-dark font-medium transition-colors duration-200 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Quay lại đăng nhập
                </a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-secondary-500 dark:text-gray-400 animate-slide-up" style="animation-delay: 0.4s">
            <p>© 2025 News Portal. Chúng tôi bảo vệ tài khoản của bạn.</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Email validation
    const emailField = document.getElementById('email');

    emailField.addEventListener('blur', function() {
        const email = this.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email && !emailRegex.test(email)) {
            this.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500', 'bg-red-50', 'dark:bg-red-900/20');
            this.classList.remove('border-green-500', 'focus:ring-green-500', 'focus:border-green-500');
        } else if (email) {
            this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500', 'bg-red-50', 'dark:bg-red-900/20');
            this.classList.add('border-green-500', 'focus:ring-green-500', 'focus:border-green-500');
        }
    });

    // Dark mode support for validation
    emailField.addEventListener('focus', function() {
        if (document.documentElement.classList.contains('dark')) {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email)) {
                this.classList.add('dark:border-red-400', 'dark:focus:ring-red-400', 'dark:focus:border-red-400');
                this.classList.remove('dark:border-green-400', 'dark:focus:ring-green-400', 'dark:focus:border-green-400');
            } else if (email) {
                this.classList.remove('dark:border-red-400', 'dark:focus:ring-red-400', 'dark:focus:border-red-400');
                this.classList.add('dark:border-green-400', 'dark:focus:ring-green-400', 'dark:focus:border-green-400');
            }
        }
    });

    // Form submission feedback
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white dark:text-gray-900" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Đang gửi...
        `;
        submitButton.disabled = true;

        // Reset after 5 seconds in case of slow response
        setTimeout(() => {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }, 5000);
    });
});
</script>
@endsection
