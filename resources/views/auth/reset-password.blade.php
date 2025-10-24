@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-accent-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 animate-fade-in">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-100-dark dark:to-primary-200-dark rounded-2xl flex items-center justify-center shadow-lg animate-bounce-subtle">
                <svg class="h-10 w-10 text-white dark:text-primary-900-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.255 3M5 10a2 2 0 012-2m6 4a2 2 0 100-4m0 4a2 2 0 100 4m0-4v8a2 2 0 002 2h8a2 2 0 002-2v-8m0 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v1"/>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark">Đặt lại mật khẩu</h2>
            <p class="mt-2 text-sm text-secondary-600 dark:text-gray-300">Tạo mật khẩu mới cho tài khoản của bạn</p>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-100 dark:border-gray-700 p-8 animate-slide-up" style="animation-delay: 0.1s">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                
                <!-- Email Field (Read-only) -->
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
                               class="block w-full pl-10 pr-3 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg bg-secondary-50 dark:bg-gray-700 text-secondary-600 dark:text-gray-300 cursor-not-allowed @error('email') !border-red-500 !bg-red-50 dark:!bg-red-900/20 @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $request->email) }}" 
                               readonly>
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

                <!-- New Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                        Mật khẩu mới
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
                               placeholder="Nhập mật khẩu mới"
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
                    
                    <!-- Password Strength Indicator -->
                    <div class="mt-2" id="password-strength">
                        <div class="flex space-x-1">
                            <div class="h-1 w-1/4 bg-secondary-200 dark:bg-gray-600 rounded-full" id="strength-1"></div>
                            <div class="h-1 w-1/4 bg-secondary-200 dark:bg-gray-600 rounded-full" id="strength-2"></div>
                            <div class="h-1 w-1/4 bg-secondary-200 dark:bg-gray-600 rounded-full" id="strength-3"></div>
                            <div class="h-1 w-1/4 bg-secondary-200 dark:bg-gray-600 rounded-full" id="strength-4"></div>
                        </div>
                        <p class="text-xs text-secondary-500 dark:text-gray-400 mt-1" id="strength-text">Nhập mật khẩu để kiểm tra độ mạnh</p>
                    </div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                        Xác nhận mật khẩu mới
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <input type="password" 
                               class="block w-full pl-10 pr-12 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 transition-colors duration-200" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Nhập lại mật khẩu mới"
                               required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" class="text-secondary-400 dark:text-gray-500 hover:text-secondary-600 dark:hover:text-gray-300 transition-colors duration-200" onclick="togglePassword('password_confirmation')">
                                <svg class="h-5 w-5" id="password_confirmation-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-2" id="password-match">
                        <p class="text-xs text-secondary-500 dark:text-gray-400" id="match-text">Mật khẩu xác nhận sẽ được kiểm tra</p>
                    </div>
                </div>

                <!-- Security Tips -->
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Mẹo tạo mật khẩu mạnh:</h3>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Ít nhất 8 ký tự</li>
                                    <li>Kết hợp chữ hoa, chữ thường</li>
                                    <li>Có chữ số và ký tự đặc biệt</li>
                                    <li>Không sử dụng thông tin cá nhân</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-primary-600 to-primary-700 dark:from-primary-100-dark dark:to-primary-200-dark hover:from-primary-700 hover:to-primary-800 dark:hover:from-primary-200-dark dark:hover:to-primary-300-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                            id="submit-btn">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-primary-200 dark:text-primary-700-dark group-hover:text-primary-100 dark:group-hover:text-primary-600-dark transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        Cập nhật mật khẩu
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Note -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-100 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.2s">
            <div class="text-center">
                <div class="flex items-center justify-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.018-.554l-1.54.687M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Bảo mật tài khoản</h3>
                </div>
                <p class="text-sm text-secondary-600 dark:text-gray-300">
                    Sau khi đặt lại mật khẩu thành công, bạn sẽ được đăng nhập tự động. 
                    Tất cả phiên đăng nhập khác sẽ bị đăng xuất để đảm bảo bảo mật.
                </p>
            </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center animate-slide-up" style="animation-delay: 0.3s">
            <p class="text-sm text-secondary-600 dark:text-gray-300">
                <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium transition-colors duration-200 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Quay lại đăng nhập
                </a>
            </p>
        </div>

        <!-- Footer -->
        <div class="text-center text-xs text-secondary-500 dark:text-gray-400 animate-slide-up" style="animation-delay: 0.4s">
            <p>© 2025 News Portal. Mật khẩu của bạn được bảo mật.</p>
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
    const colors = ['bg-red-500', 'bg-yellow-500', 'bg-blue-500', 'bg-primary-500'];
    const darkColors = ['dark:bg-red-400', 'dark:bg-yellow-400', 'dark:bg-blue-400', 'dark:bg-primary-400-dark'];
    const texts = ['Rất yếu', 'Yếu', 'Trung bình', 'Mạnh', 'Rất mạnh'];

    indicators.forEach((id, index) => {
        const element = document.getElementById(id);
        element.className = element.className.replace(/bg-\w+-\d+/g, '').replace(/dark:bg-\w+-\d+/g, '');
        if (index < strength) {
            element.classList.add(colors[Math.min(strength - 1, colors.length - 1]]);
            if (document.documentElement.classList.contains('dark')) {
                element.classList.add(darkColors[Math.min(strength - 1, darkColors.length - 1]]);
            }
        } else {
            element.classList.add('bg-secondary-200');
            if (document.documentElement.classList.contains('dark')) {
                element.classList.add('dark:bg-gray-600');
            }
        }
    });

    const strengthText = document.getElementById('strength-text');
    strengthText.className = strengthText.className.replace(/text-\w+-\d+/g, '');
    if (strength > 0) {
        strengthText.classList.add(strength >= 4 ? 'text-primary-600 dark:text-primary-400-dark' : strength >= 3 ? 'text-blue-600 dark:text-blue-400' : strength >= 2 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400');
    } else {
        strengthText.classList.add('text-secondary-500 dark:text-gray-400');
    }

    document.getElementById('strength-text').textContent = strength > 0 ? texts[strength - 1] : 'Nhập mật khẩu để kiểm tra độ mạnh';
    return strength;
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmation = document.getElementById('password_confirmation').value;
    const matchElement = document.getElementById('match-text');

    if (confirmation.length === 0) {
        matchElement.textContent = 'Mật khẩu xác nhận sẽ được kiểm tra';
        matchElement.className = 'text-xs text-secondary-500 dark:text-gray-400';
    } else if (password === confirmation) {
        matchElement.textContent = '✓ Mật khẩu khớp';
        matchElement.className = 'text-xs text-primary-600 dark:text-primary-400-dark';
    } else {
        matchElement.textContent = '✗ Mật khẩu không khớp';
        matchElement.className = 'text-xs text-red-600 dark:text-red-400';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmationField = document.getElementById('password_confirmation');
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

    function updateSubmitButton() {
        const password = passwordField.value;
        const confirmation = confirmationField.value;
        const passwordStrong = checkPasswordStrength(password) >= 3;
        const passwordsMatch = password === confirmation && password.length > 0;

        if (passwordStrong && passwordsMatch) {
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    const form = document.getElementById('resetForm');
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
                    this.classList.remove('dark:border-primary-400-dark', 'dark:focus:ring-primary-400-dark', 'dark:focus:border-primary-400-dark');
                } else {
                    this.classList.remove('dark:border-red-400', 'dark:focus:ring-red-400', 'dark:focus:border-red-400');
                    this.classList.add('dark:border-primary-400-dark', 'dark:focus:ring-primary-400-dark', 'dark:focus:border-primary-400-dark');
                }
            }
        });
    });

    updateSubmitButton();

    form.addEventListener('submit', function() {
        const originalText = submitButton.innerHTML;

        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white dark:text-gray-900" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Đang cập nhật...
        `;
        submitButton.disabled = true;
    });
});
</script>
@endsection
