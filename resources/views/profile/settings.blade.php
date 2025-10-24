@extends('layouts.app')

@section('title', 'Cài đặt tài khoản')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-primary-100-dark">Cài đặt tài khoản</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Quản lý cài đặt bảo mật và tài khoản</p>
                </div>
                <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Quay lại hồ sơ
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-primary-50 dark:bg-primary-900-dark dark:border-primary-700-dark dark:text-primary-100-dark border border-primary-200 text-primary-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-8">
            <!-- Change Password Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-primary-100-dark">Đổi mật khẩu</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cập nhật mật khẩu để bảo mật tài khoản</p>
                </div>
                
                <form action="{{ route('profile.password') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mật khẩu hiện tại
                        </label>
                        <input type="password" name="current_password" id="current_password" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mật khẩu mới
                            </label>
                            <input type="password" name="password" id="password" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Xác nhận mật khẩu mới
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">
                        </div>
                    </div>
                    
                    <!-- Password Requirements -->
                    <div class="bg-primary-50 dark:bg-primary-900-dark dark:border-primary-700-dark border border-primary-200 rounded-lg p-4">
                         <h4 class="text-sm font-medium text-primary-900 dark:text-primary-100-dark mb-2">Yêu cầu mật khẩu:</h4>
                         <ul class="text-sm text-primary-800 dark:text-primary-200-dark space-y-1">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Ít nhất 8 ký tự
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Bao gồm chữ hoa, chữ thường và số
                            </li>
                        </ul>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-6 py-2 bg-primary-600 dark:bg-primary-500-dark text-white rounded-lg hover:bg-primary-700 dark:hover:bg-primary-400-dark transition duration-150">
                            Cập nhật mật khẩu
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-primary-100-dark">Thông tin tài khoản</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Thông tin cơ bản về tài khoản của bạn</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <div class="flex items-center space-x-3">
                                <span class="text-gray-900 dark:text-primary-100-dark">{{ $user->email }}</span>
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900-dark text-primary-800 dark:text-primary-200-dark">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Đã xác minh
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                        Chưa xác minh
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vai trò</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->isAdmin() ? 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200' : 'bg-primary-100 dark:bg-primary-900-dark text-primary-800 dark:text-primary-200-dark' }}">
                                {{ $user->isAdmin() ? 'Quản trị viên' : 'Người dùng' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ngày tham gia</label>
                            <span class="text-gray-900 dark:text-primary-100-dark">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Lượt xem hồ sơ</label>
                            <span class="text-gray-900 dark:text-primary-100-dark">{{ number_format($user->profile_views) }} lượt</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Integration -->
            @if($user->google_id)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-primary-100-dark">Liên kết Google</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Tài khoản của bạn đã được liên kết với Google</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                                    <svg class="w-6 h-6 text-red-600" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-primary-100-dark">Tài khoản Google</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Đã liên kết thành công</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 dark:bg-primary-900-dark text-primary-800 dark:text-primary-200-dark">
                                Đã kết nối
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Danger Zone -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-red-200 dark:border-red-700">
                <div class="px-6 py-4 border-b border-red-200 dark:border-red-700">
                    <h2 class="text-lg font-medium text-red-900 dark:text-red-100">Vùng nguy hiểm</h2>
                    <p class="text-sm text-red-600 dark:text-red-400 mt-1">Các hành động không thể hoàn tác</p>
                </div>
                
                <div class="p-6">
                    <div class="bg-red-50 dark:bg-red-900 dark:border-red-700 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Xóa tài khoản</h3>
                                <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                    <p>Một khi bạn xóa tài khoản, không có cách nào để khôi phục lại. Tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn.</p>
                                </div>
                                <div class="mt-4">
                                    <button type="button" 
                                            onclick="alert('Tính năng này sẽ được phát triển trong phiên bản tương lai.')"
                                            class="bg-red-600 dark:bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 dark:hover:bg-red-400 transition duration-150">
                                        Xóa tài khoản
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password strength indicator
document.getElementById('password').addEventListener('input', function(e) {
    const password = e.target.value;
    const strength = checkPasswordStrength(password);
    // You can add password strength indicator here
});

function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}
</script>
@endsection
