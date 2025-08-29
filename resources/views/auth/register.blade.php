@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-accent-50 via-white to-primary-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 animate-fade-in">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-accent-600 to-accent-700 rounded-2xl flex items-center justify-center shadow-lg animate-bounce-subtle">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-heading font-bold text-secondary-900">Tạo tài khoản mới</h2>
            <p class="mt-2 text-sm text-secondary-600">Tham gia cộng đồng và khám phá nội dung tuyệt vời</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-2xl shadow-xl border border-secondary-100 p-8 animate-slide-up" style="animation-delay: 0.1s">
            <form method="POST" action="{{ route('register') }}" class="space-y-6" id="registerForm">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-secondary-700 mb-2">
                        Họ và tên
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               class="block w-full pl-10 pr-3 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-colors duration-200 @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 bg-red-50 @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Nhập họ và tên của bạn"
                               required>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-secondary-700 mb-2">
                        Địa chỉ email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input type="email" 
                               class="block w-full pl-10 pr-3 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-colors duration-200 @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 bg-red-50 @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Nhập địa chỉ email của bạn"
                               required>
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-secondary-700 mb-2">
                        Mật khẩu
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" 
                               class="block w-full pl-10 pr-12 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-colors duration-200 @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 bg-red-50 @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Tạo mật khẩu mạnh"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" class="text-secondary-400 hover:text-secondary-600 transition-colors duration-200" onclick="togglePassword('password')">
                                <svg class="h-5 w-5" id="password-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    
                    <!-- Password Strength Indicator -->
                    <div class="mt-2" id="password-strength">
                        <div class="flex space-x-1">
                            <div class="h-1 w-1/4 bg-secondary-200 rounded-full" id="strength-1"></div>
                            <div class="h-1 w-1/4 bg-secondary-200 rounded-full" id="strength-2"></div>
                            <div class="h-1 w-1/4 bg-secondary-200 rounded-full" id="strength-3"></div>
                            <div class="h-1 w-1/4 bg-secondary-200 rounded-full" id="strength-4"></div>
                        </div>
                        <p class="text-xs text-secondary-500 mt-1" id="strength-text">Nhập mật khẩu để kiểm tra độ mạnh</p>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-secondary-700 mb-2">
                        Xác nhận mật khẩu
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <input type="password" 
                               class="block w-full pl-10 pr-12 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-colors duration-200" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Nhập lại mật khẩu"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" class="text-secondary-400 hover:text-secondary-600 transition-colors duration-200" onclick="togglePassword('password_confirmation')">
                                <svg class="h-5 w-5" id="password_confirmation-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-2" id="password-match">
                        <p class="text-xs text-secondary-500" id="match-text">Mật khẩu xác nhận sẽ được kiểm tra</p>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input type="checkbox" 
                               class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-secondary-300 rounded transition-colors duration-200" 
                               id="terms" 
                               name="terms" 
                               required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-secondary-700 cursor-pointer">
                            Tôi đồng ý với 
                            <a href="#" class="text-accent-600 hover:text-accent-700 font-medium">Điều khoản sử dụng</a> 
                            và 
                            <a href="#" class="text-accent-600 hover:text-accent-700 font-medium">Chính sách bảo mật</a>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-accent-600 to-accent-700 hover:from-accent-700 hover:to-accent-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                            id="submit-btn">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-accent-200 group-hover:text-accent-100 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </span>
                        Tạo tài khoản
                    </button>
                </div>
            </form>
        </div>

        <!-- Social Register -->
        <div class="bg-white rounded-2xl shadow-xl border border-secondary-100 p-6 animate-slide-up" style="animation-delay: 0.2s">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-secondary-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-secondary-500">Hoặc đăng ký với</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('google.redirect') }}" class="w-full inline-flex justify-center py-3 px-4 border border-secondary-300 rounded-lg shadow-sm bg-white text-sm font-medium text-secondary-700 hover:bg-secondary-50 transition-colors duration-200">
                    <svg class="h-5 w-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="ml-2">Đăng ký với Google</span>
                </a>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center animate-slide-up" style="animation-delay: 0.3s">
            <p class="text-sm text-secondary-600">
                Đã có tài khoản? 
                <a href="{{ route('login') }}" class="text-accent-600 hover:text-accent-700 font-medium transition-colors duration-200">
                    Đăng nhập ngay
                </a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-secondary-500 animate-slide-up" style="animation-delay: 0.4s">
            <p>© 2025 News Portal. Cam kết bảo vệ thông tin cá nhân của bạn.</p>
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

function checkPasswordStrength(password) {
    let strength = 0;
    const checks = [
        password.length >= 8,
        /[a-z]/.test(password),
        /[A-Z]/.test(password),
        /[0-9]/.test(password),
        /[^A-Za-z0-9]/.test(password)
    ];
    
    strength = checks.filter(Boolean).length;
    
    const indicators = ['strength-1', 'strength-2', 'strength-3', 'strength-4'];
    const colors = ['bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
    const texts = ['Rất yếu', 'Yếu', 'Trung bình', 'Mạnh', 'Rất mạnh'];
    
    indicators.forEach((id, index) => {
        const element = document.getElementById(id);
        element.className = element.className.replace(/bg-\w+-\d+/g, '');
        if (index < strength) {
            element.classList.add(colors[Math.min(strength - 1, colors.length - 1)]);
        } else {
            element.classList.add('bg-secondary-200');
        }
    });
    
    document.getElementById('strength-text').textContent = strength > 0 ? texts[strength - 1] : 'Nhập mật khẩu để kiểm tra độ mạnh';
    return strength;
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    const matchElement = document.getElementById('match-text');
    
    if (confirmation.length === 0) {
        matchElement.textContent = 'Mật khẩu xác nhận sẽ được kiểm tra';
        matchElement.className = 'text-xs text-secondary-500';
    } else if (password === confirmation) {
        matchElement.textContent = '✓ Mật khẩu khớp';
        matchElement.className = 'text-xs text-green-600';
    } else {
        matchElement.textContent = '✗ Mật khẩu không khớp';
        matchElement.className = 'text-xs text-red-600';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmationField = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('terms');
    const submitButton = document.getElementById('submit-btn');
    
    passwordField.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        checkPasswordMatch();
        updateSubmitButton();
    });
    
    confirmationField.addEventListener('input', function() {
        checkPasswordMatch();
        updateSubmitButton();
    });
    
    termsCheckbox.addEventListener('change', updateSubmitButton);
    
    function updateSubmitButton() {
        const password = passwordField.value;
        const confirmation = confirmationField.value;
        const termsAccepted = termsCheckbox.checked;
        const passwordStrong = checkPasswordStrength(password) >= 3;
        const passwordsMatch = password === confirmation && password.length > 0;
        
        if (passwordStrong && passwordsMatch && termsAccepted) {
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }
    
    // Initial state
    updateSubmitButton();
});
</script>
@endsection
