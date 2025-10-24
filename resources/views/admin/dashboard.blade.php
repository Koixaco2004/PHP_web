@extends('layouts.app')

@section('title', 'Admin Dashboard')

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-heading font-bold text-white">Admin Dashboard</h1>
                <p class="text-primary-100 dark:text-primary-200 mt-2">Quản lý toàn bộ hệ thống website tin tức</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center text-white">
            <div class="text-right">
                <p class="text-sm text-primary-100 dark:text-primary-200">Xin chào,</p>
                <p class="font-semibold text-lg">{{ Auth::user()->name }}</p>
                <p class="text-xs text-primary-200 dark:text-primary-300">{{ Auth::user()->role === 'admin' ? 'Quản trị viên' : 'Biên tập viên' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Posts -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up hover:shadow-lg dark:hover:shadow-gray-900/20 transition-shadow duration-300" style="animation-delay: 0.1s">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Tổng bài viết</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-primary-400-dark">{{ $stats['total_posts'] }}</p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-secondary-100 dark:border-gray-700">
            <div class="flex items-center text-sm">
                <span class="text-blue-600 dark:text-blue-400 font-medium">+12%</span>
                <span class="text-secondary-600 dark:text-gray-300 ml-1">so với tháng trước</span>
            </div>
        </div>
    </div>

    <!-- Published Posts -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up hover:shadow-lg dark:hover:shadow-gray-900/20 transition-shadow duration-300" style="animation-delay: 0.2s">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Đã xuất bản</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-primary-400-dark">{{ $stats['published_posts'] }}</p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-secondary-100 dark:border-gray-700">
            <div class="flex items-center text-sm">
                <div class="w-full bg-secondary-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['total_posts'] > 0 ? ($stats['published_posts'] / $stats['total_posts'] * 100) : 0 }}%"></div>
                </div>
                <span class="ml-2 text-secondary-600 dark:text-gray-300 whitespace-nowrap">
                    {{ $stats['total_posts'] > 0 ? round($stats['published_posts'] / $stats['total_posts'] * 100) : 0 }}%
                </span>
            </div>
        </div>
    </div>

    <!-- Pending Posts -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up hover:shadow-lg dark:hover:shadow-gray-900/20 transition-shadow duration-300" style="animation-delay: 0.25s">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Chờ phê duyệt</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-primary-400-dark">{{ $stats['pending_posts'] }}</p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-secondary-100 dark:border-gray-700">
            <a href="{{ route('admin.posts.pending') }}" class="flex items-center text-sm text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300">
                <span>Xem tất cả</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up hover:shadow-lg dark:hover:shadow-gray-900/20 transition-shadow duration-300" style="animation-delay: 0.3s">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Tổng người dùng</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-primary-400-dark">{{ $stats['total_users'] }}</p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t border-secondary-100 dark:border-gray-700">
            <div class="flex items-center text-sm">
                <span class="text-indigo-600 dark:text-indigo-400 font-medium">{{ $stats['admin_users'] ?? 0 }} admin</span>
                <span class="text-secondary-600 dark:text-gray-300 ml-1">• {{ $stats['total_users'] - ($stats['admin_users'] ?? 0) }} thành viên</span>
            </div>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Recent Posts -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.5s">
            <div class="px-6 py-4 border-b border-secondary-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-secondary-900 dark:text-primary-400-dark flex items-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Bài viết gần đây
                    </h2>
                    <a href="{{ route('posts.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 text-sm font-medium">
                        Xem tất cả →
                    </a>
                </div>
            </div>
            <div class="p-6">
                @forelse($recentPosts as $index => $post)
                    <div class="flex items-start space-x-4 mb-6 last:mb-0 animate-fade-in" style="animation-delay: {{ 0.1 * ($index + 1) }}s">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-100 dark:from-primary-900 to-primary-200 dark:to-primary-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-secondary-900 dark:text-primary-400-dark mb-1">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary-600 dark:hover:text-primary-300-dark transition-colors duration-200">
                                            {{ Str::limit($post->title, 60) }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-secondary-600 dark:text-gray-300 mb-2">
                                        Bởi <span class="font-medium">{{ $post->user->name }}</span> • {{ $post->created_at->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="text-sm text-secondary-700 dark:text-gray-300">
                                        {{ Str::limit($post->excerpt ?? strip_tags($post->content), 100) }}
                                    </p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($post->approval_status === 'approved') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                        @elseif($post->approval_status === 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                        @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                        @endif">
                                        @if($post->approval_status === 'approved') ✓ Đã duyệt
                                        @elseif($post->approval_status === 'pending') ⏳ Chờ duyệt
                                        @else ✕ Từ chối
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-secondary-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-secondary-600 dark:text-gray-300">Chưa có bài viết nào.</p>
                        <a href="{{ route('posts.create') }}" class="btn-primary mt-3 inline-flex">
                            Tạo bài viết đầu tiên
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 animate-slide-up" style="animation-delay: 0.6s">
        <div class="px-6 py-4 border-b border-secondary-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-secondary-900 dark:text-primary-400-dark flex items-center">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Hành động nhanh
            </h2>
        </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="{{ route('posts.create') }}" class="flex items-center w-full p-3 text-left bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 hover:from-blue-100 dark:hover:from-blue-800 hover:to-blue-200 dark:hover:to-blue-700 rounded-lg transition-all duration-200 group">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-600 dark:group-hover:bg-blue-400 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-blue-900 dark:text-blue-100">Tạo bài viết mới</p>
                            <p class="text-xs text-blue-700 dark:text-blue-200">Viết và xuất bản nội dung</p>
                        </div>
                    </a>

                    <a href="{{ route('categories.create') }}" class="flex items-center w-full p-3 text-left bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 hover:from-green-100 dark:hover:from-green-800 hover:to-green-200 dark:hover:to-green-700 rounded-lg transition-all duration-200 group">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-600 dark:group-hover:bg-green-400 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-green-900 dark:text-green-100">Tạo chuyên mục</p>
                            <p class="text-xs text-green-700 dark:text-green-200">Phân loại nội dung</p>
                        </div>
                    </a>

                    <a href="{{ route('posts.index') }}" class="flex items-center w-full p-3 text-left bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900 dark:to-indigo-800 hover:from-indigo-100 dark:hover:from-indigo-800 hover:to-indigo-200 dark:hover:to-indigo-700 rounded-lg transition-all duration-200 group">
                        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-indigo-600 dark:group-hover:bg-indigo-400 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-indigo-900 dark:text-indigo-100">Quản lý bài viết</p>
                            <p class="text-xs text-indigo-700 dark:text-indigo-200">Chỉnh sửa và xóa nội dung</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.posts.pending') }}" class="flex items-center w-full p-3 text-left bg-gradient-to-r from-yellow-50 to-yellow-100 dark:from-yellow-900 dark:to-yellow-800 hover:from-yellow-100 dark:hover:from-yellow-800 hover:to-yellow-200 dark:hover:to-yellow-700 rounded-lg transition-all duration-200 group">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-600 dark:group-hover:bg-yellow-400 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-yellow-900 dark:text-yellow-100">Phê duyệt bài viết</p>
                            <p class="text-xs text-yellow-700 dark:text-yellow-200">{{ $stats['pending_posts'] }} bài chờ duyệt</p>
                        </div>
                    </a>

                    <a href="{{ route('categories.index') }}" class="flex items-center w-full p-3 text-left bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900 dark:to-pink-800 hover:from-pink-100 dark:hover:from-pink-800 hover:to-pink-200 dark:hover:to-pink-700 rounded-lg transition-all duration-200 group">
                        <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-pink-600 dark:group-hover:bg-pink-400 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-pink-900 dark:text-pink-100">Quản lý chuyên mục</p>
                            <p class="text-xs text-pink-700 dark:text-pink-200">Cấu hình phân loại</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="flex items-center w-full p-3 text-left bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 hover:from-purple-100 dark:hover:from-purple-800 hover:to-purple-200 dark:hover:to-purple-700 rounded-lg transition-all duration-200 group">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-600 dark:group-hover:bg-purple-400 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-purple-900 dark:text-purple-100">Quản lý người dùng</p>
                            <p class="text-xs text-purple-700 dark:text-purple-200">Cấp quyền và xóa tài khoản</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.comments.index') }}" class="flex items-center w-full p-3 text-left bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 hover:from-orange-100 dark:hover:from-orange-800 hover:to-orange-200 dark:hover:to-orange-700 rounded-lg transition-all duration-200 group">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-orange-600 dark:group-hover:bg-orange-400 transition-colors duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-orange-900 dark:text-orange-100">Quản lý bình luận</p>
                            <p class="text-xs text-orange-700 dark:text-orange-200">Giám sát và xóa spam</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click animation to action cards
    const actionCards = document.querySelectorAll('[href*="route"]');
    actionCards.forEach(card => {
        card.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    });
});
</script>
@endsection
