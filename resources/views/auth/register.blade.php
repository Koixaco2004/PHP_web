@extends('layouts.app')

@section('title', 'Đăng ký - VN News')

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
                    <i class="bi bi-person-plus"></i>
                </div>
                <h1 class="auth-title">Tạo tài khoản mới</h1>
                <p class="auth-subtitle">Tham gia cộng đồng VN News ngay hôm nay</p>
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

                <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
                    @csrf
                    
                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="bi bi-person"></i>
                            Họ và tên
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Nhập họ và tên đầy đủ"
                               required 
                               autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                                   placeholder="Tạo mật khẩu mạnh"
                                   required 
                                   autocomplete="new-password"
                                   minlength="8">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="bi bi-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <!-- Password Strength Meter -->
                        <div class="password-strength" id="passwordStrength" style="display: none;">
                            <div class="strength-meter">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-text" id="strengthText"></div>
                        </div>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-shield-check"></i>
                            Xác nhận mật khẩu
                        </label>
                        <div class="password-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Nhập lại mật khẩu để xác nhận"
                                   required 
                                   autocomplete="new-password">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="bi bi-eye" id="password_confirmationToggleIcon"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" style="display: none; font-size: 0.875rem; margin-top: 0.5rem;"></div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            Tôi đồng ý với 
                            <a href="#" style="color: var(--accent-color); text-decoration: none;">Điều khoản sử dụng</a> 
                            và 
                            <a href="#" style="color: var(--accent-color); text-decoration: none;">Chính sách bảo mật</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn auth-btn-primary" id="submitBtn" disabled>
                        <span class="btn-text">
                            <i class="bi bi-person-plus"></i>
                            Tạo tài khoản
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
                        Đăng ký với Google
                    </a>
                    <a href="#" class="social-btn">
                        <i class="bi bi-facebook" style="color: #4267b2;"></i>
                        Đăng ký với Facebook
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <div class="auth-links">
                    <div class="auth-link">
                        Đã có tài khoản? 
                        <a href="{{ route('login') }}">Đăng nhập ngay</a>
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
    const form = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const spinner = submitBtn.querySelector('.loading-spinner');
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('terms');

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

    // Password strength checker
    passwordField.addEventListener('input', function() {
        const password = this.value;
        const strengthMeter = document.getElementById('passwordStrength');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        
        if (password.length > 0) {
            strengthMeter.style.display = 'block';
            const strength = checkPasswordStrength(password);
            
            strengthFill.className = `strength-fill strength-${strength.level}`;
            strengthText.textContent = strength.text;
            strengthText.style.color = strength.color;
        } else {
            strengthMeter.style.display = 'none';
        }
        
        checkFormValidity();
    });

    // Password confirmation checker
    passwordConfirmField.addEventListener('input', function() {
        const password = passwordField.value;
        const confirmPassword = this.value;
        const matchDiv = document.getElementById('passwordMatch');
        
        if (confirmPassword.length > 0) {
            matchDiv.style.display = 'block';
            
            if (password === confirmPassword) {
                matchDiv.innerHTML = '<i class="bi bi-check-circle" style="color: var(--success-color);"></i> Mật khẩu khớp';
                matchDiv.style.color = 'var(--success-color)';
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                matchDiv.innerHTML = '<i class="bi bi-x-circle" style="color: var(--danger-color);"></i> Mật khẩu không khớp';
                matchDiv.style.color = 'var(--danger-color)';
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        } else {
            matchDiv.style.display = 'none';
            this.classList.remove('is-valid', 'is-invalid');
        }
        
        checkFormValidity();
    });

    // Terms checkbox
    termsCheckbox.addEventListener('change', checkFormValidity);

    function checkPasswordStrength(password) {
        let score = 0;
        
        // Length
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        
        // Character types
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        if (score < 3) {
            return { level: 'weak', text: 'Mật khẩu yếu', color: 'var(--danger-color)' };
        } else if (score < 4) {
            return { level: 'fair', text: 'Mật khẩu tạm được', color: '#f59e0b' };
        } else if (score < 5) {
            return { level: 'good', text: 'Mật khẩu tốt', color: '#10b981' };
        } else {
            return { level: 'strong', text: 'Mật khẩu mạnh', color: 'var(--success-color)' };
        }
    }

    function checkFormValidity() {
        const password = passwordField.value;
        const confirmPassword = passwordConfirmField.value;
        const termsChecked = termsCheckbox.checked;
        const nameValid = document.getElementById('name').value.trim().length >= 2;
        const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(document.getElementById('email').value);
        
        const isValid = password.length >= 8 && 
                       password === confirmPassword && 
                       termsChecked && 
                       nameValid && 
                       emailValid;
        
        submitBtn.disabled = !isValid;
    }

    // Form validation enhancement
    const inputs = form.querySelectorAll('input[required]:not([type="checkbox"])');
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

        // Field-specific validation
        if (field.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(value)) {
                field.classList.add('is-valid');
            } else {
                field.classList.add('is-invalid');
            }
        } else if (field.name === 'name') {
            if (value.length >= 2) {
                field.classList.add('is-valid');
            } else {
                field.classList.add('is-invalid');
            }
        } else if (field.type === 'password' && field.name === 'password') {
            if (value.length >= 8) {
                field.classList.add('is-valid');
            } else {
                field.classList.add('is-invalid');
            }
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
