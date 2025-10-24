@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 animate-fade-in">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-100-dark dark:to-primary-200-dark rounded-2xl flex items-center justify-center shadow-lg animate-bounce-subtle">
                <svg class="h-10 w-10 text-white dark:text-primary-900-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark">Chào mừng trở lại!</h2>
            <p class="mt-2 text-sm text-secondary-600 dark:text-gray-300">Đăng nhập vào tài khoản của bạn để tiếp tục</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-100 dark:border-gray-700 p-8 animate-slide-up" style="animation-delay: 0.1s">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                        Địa chỉ email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input type="email" 
                               class="block w-full pl-10 pr-3 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 transition-colors duration-200 @error('email') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:!bg-red-900/20 @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Nhập địa chỉ email của bạn"
                               required>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                        Mật khẩu
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" 
                               class="block w-full pl-10 pr-12 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 transition-colors duration-200 @error('password') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:!bg-red-900/20 @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Nhập mật khẩu của bạn"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" class="text-secondary-400 dark:text-gray-500 hover:text-secondary-600 dark:hover:text-gray-300 transition-colors duration-200" onclick="togglePassword('password')">
                                <svg class="h-5 w-5" id="password-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               class="h-4 w-4 text-primary-600 dark:text-primary-400-dark focus:ring-primary-500 dark:focus:ring-primary-400-dark border-secondary-300 dark:border-gray-600 rounded transition-colors duration-200" 
                               id="remember" 
                               name="remember">
                        <label for="remember" class="ml-2 block text-sm text-secondary-700 dark:text-gray-300 cursor-pointer">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium transition-colors duration-200">
                            Quên mật khẩu?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-primary-600 to-primary-700 dark:from-primary-100-dark dark:to-primary-200-dark hover:from-primary-700 hover:to-primary-800 dark:hover:from-primary-200-dark dark:hover:to-primary-300-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-primary-200 dark:text-primary-700-dark group-hover:text-primary-100 dark:group-hover:text-primary-600-dark transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </span>
                        Đăng nhập
                    </button>
                </div>
            </form>
        </div>

        <!-- Social Login -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-100 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.2s">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-secondary-300 dark:border-gray-600"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-gray-800 text-secondary-500 dark:text-gray-400">Hoặc đăng nhập với</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('google.redirect') }}" class="w-full inline-flex justify-center py-3 px-4 border border-secondary-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-secondary-700 dark:text-gray-300 hover:bg-secondary-50 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="h-5 w-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="ml-2">Đăng nhập với Google</span>
                </a>
            </div>
        </div>

        <!-- Register Link -->
        <div class="text-center animate-slide-up" style="animation-delay: 0.3s">
            <p class="text-sm text-secondary-600 dark:text-gray-300">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium transition-colors duration-200">
                    Đăng ký ngay
                </a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-secondary-500 dark:text-gray-400 animate-slide-up" style="animation-delay: 0.4s">
            <p>© 2025 News Portal. Bảo mật và riêng tư được bảo vệ.</p>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m-3.122-3.122l4.243 4.243"/>';
    } else {
        field.type = 'password';
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

// Form validation feedback
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                this.classList.remove('border-primary-500', 'focus:ring-primary-500', 'focus:border-primary-500');
            } else {
                this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                this.classList.add('border-primary-500', 'focus:ring-primary-500', 'focus:border-primary-500');
            }
        });

        input.addEventListener('focus', function() {
            if (document.documentElement.classList.contains('dark')) {
                if (!this.value.trim()) {
                    this.classList.add('dark:border-red-400', 'dark:focus:ring-red-400', 'dark:focus:border-red-400');
                    this.classList.remove('dark:border-primary-400', 'dark:focus:ring-primary-400', 'dark:focus:border-primary-400');
                } else {
                    this.classList.remove('dark:border-red-400', 'dark:focus:ring-red-400', 'dark:focus:border-red-400');
                    this.classList.add('dark:border-primary-400', 'dark:focus:ring-primary-400', 'dark:focus:border-primary-400');
                }
            }
        });
    });
});
</script>
@endsection
