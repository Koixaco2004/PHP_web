@extends('layouts.app')

@section('title', 'Chỉnh sửa Người dùng')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-900 rounded-xl shadow-lg p-8 mb-8 animate-slide-up">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 rounded-xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-heading font-bold text-white">Chỉnh sửa Người dùng</h1>
                <p class="text-primary-100 dark:text-primary-200 mt-2">Cập nhật thông tin và vai trò của {{ $user->name }}</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center">
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                ← Quay lại danh sách
            </a>
        </div>
    </div>
</div>

<!-- Edit Form -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-8 animate-slide-up">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- User Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                    Tên người dùng
                </label>
                <div class="flex items-center space-x-3 p-4 bg-secondary-50 dark:bg-gray-700 rounded-lg">
                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $user->avatar ?? asset('hello.png') }}" alt="{{ $user->name }}">
                    <div>
                        <p class="font-medium text-secondary-900 dark:text-primary-100-dark">{{ $user->name }}</p>
                        <p class="text-sm text-secondary-500 dark:text-gray-300">ID: {{ $user->id }}</p>
                    </div>
                </div>
            </div>

            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                    Email
                </label>
                <div class="flex items-center space-x-2 p-3 bg-secondary-50 dark:bg-gray-700 rounded-lg">
                    <svg class="w-5 h-5 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-secondary-900 dark:text-primary-100-dark">{{ $user->email }}</span>
                    @if($user->email_verified_at)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 ml-2">
                            ✓ Đã xác thực
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 ml-2">
                            Chưa xác thực
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Role Selection -->
        <div>
            <label for="role" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                Vai trò
            </label>
            <select id="role" name="role" class="w-full px-3 py-2 border border-secondary-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-secondary-900 dark:text-primary-100-dark focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin - Quản trị viên hệ thống</option>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User - Người dùng thường</option>
                <option value="subscriber" {{ $user->role === 'subscriber' ? 'selected' : '' }}>Subscriber - Thuê bao</option>
            </select>
            <p class="mt-1 text-sm text-secondary-500 dark:text-gray-400">
                Chọn vai trò phù hợp cho người dùng. Admin có toàn quyền quản lý hệ thống.
            </p>
        </div>

        <!-- Additional Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-secondary-50 dark:bg-gray-700 rounded-lg">
            <div class="text-center">
                <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $user->posts()->count() }}</div>
                <div class="text-sm text-secondary-600 dark:text-gray-300">Bài viết</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $user->comments()->count() }}</div>
                <div class="text-sm text-secondary-600 dark:text-gray-300">Bình luận</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $user->created_at->diffForHumans() }}</div>
                <div class="text-sm text-secondary-600 dark:text-gray-300">Tham gia</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-secondary-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                @if($user->id !== Auth::user()->id)
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn-danger"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác.')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Xóa người dùng
                        </button>
                    </form>
                @else
                    <span class="text-sm text-secondary-500 dark:text-gray-400 italic">
                        Bạn không thể xóa tài khoản của chính mình
                    </span>
                @endif
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    Hủy
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Cập nhật
                </button>
            </div>
        </div>
    </form>
</div>
@endsection