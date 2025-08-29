@extends('layouts.app')

@section('title', 'Đăng nhập - VN News')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-wrapper">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h1 class="auth-title">Chào mừng trở lại</h1>
                <p class="auth-subtitle">Đăng nhập để tiếp tục với VN News</p>
            </div>

            <!-- Body -->
            <div class="auth-body">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="auth-alert auth-alert-success">
                        <i class="bi bi-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="auth-alert auth-alert-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i>
                            Địa chỉ email
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Nhập địa chỉ email của bạn"
                               required 
                               autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="bi bi-shield-lock"></i>
                            Mật khẩu
                        </label>
                        <div class="password-group">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Nhập mật khẩu của bạn"
                                   required 
                                   autocomplete="current-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="bi bi-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn auth-btn-primary" id="submitBtn">
                        <span class="btn-text">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Đăng nhập
                        </span>
                        <div class="loading-spinner" style="display: none;"></div>
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span>hoặc</span>
                </div>

                <!-- Social Login -->
                <div class="social-login">
                    <a href="#" class="social-btn">
                        <i class="bi bi-google" style="color: #db4437;"></i>
                        Đăng nhập với Google
                    </a>
                    <a href="#" class="social-btn">
                        <i class="bi bi-facebook" style="color: #4267b2;"></i>
                        Đăng nhập với Facebook
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <div class="auth-links">
                    <div class="auth-link">
                        Chưa có tài khoản? 
                        <a href="{{ route('register') }}">Đăng ký ngay</a>
                    </div>
                    <div class="auth-link">
                        <a href="#" onclick="showForgotPassword()">Quên mật khẩu?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar')
<!-- No sidebar for auth pages -->
@endsection

@section('additional_js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.loading-spinner');

    // Form submission
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        spinner.style.display = 'block';
    });

    // Password toggle
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + 'ToggleIcon');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            field.type = 'password';
            icon.className = 'bi bi-eye';
        }
    };

    // Forgot password modal (placeholder)
    window.showForgotPassword = function() {
        alert('Tính năng quên mật khẩu sẽ được triển khai sớm!');
    };

    // Form validation enhancement
    const inputs = form.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearFieldError);
    });

    function validateField(event) {
        const field = event.target;
        const value = field.value.trim();
        
        // Remove existing validation classes
        field.classList.remove('is-valid', 'is-invalid');
        
        if (value === '') {
            field.classList.add('is-invalid');
            return;
        }

        // Email validation
        if (field.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(value)) {
                field.classList.add('is-valid');
            } else {
                field.classList.add('is-invalid');
            }
        } else if (field.type === 'password') {
            if (value.length >= 6) {
                field.classList.add('is-valid');
            } else {
                field.classList.add('is-invalid');
            }
        } else {
            field.classList.add('is-valid');
        }
    }

    function clearFieldError(event) {
        const field = event.target;
        if (field.classList.contains('is-invalid') && field.value.trim() !== '') {
            field.classList.remove('is-invalid');
        }
    }
});
</script>
@endsection
