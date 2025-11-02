@extends('layouts.app')

@section('title', 'Bài viết của tôi')

@section('content')
<div class="container mx-auto px-4 py-4 sm:py-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-900 rounded-xl shadow-lg p-4 sm:p-8 mb-6 sm:mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 sm:mr-6">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-4xl font-heading font-bold text-white">Bài viết của tôi</h1>
                    <p class="text-sm sm:text-base text-primary-100 mt-1 sm:mt-2">Quản lý tất cả bài viết bạn đã tạo</p>
                </div>
            </div>
            <a href="{{ route('posts.create') }}" class="hidden lg:flex bg-white text-primary-600 hover:bg-primary-50 px-6 py-3 rounded-lg font-semibold items-center transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tạo bài viết mới
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-3 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center">
                <div class="w-8 h-8 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mx-auto sm:mx-0 mb-2 sm:mb-0 sm:mr-4">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-[10px] sm:text-sm text-secondary-600 dark:text-gray-300">Tổng bài viết</p>
                    <p class="text-lg sm:text-2xl font-bold text-secondary-900 dark:text-white">{{ $posts->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-3 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center">
                <div class="w-8 h-8 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mx-auto sm:mx-0 mb-2 sm:mb-0 sm:mr-4">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-[10px] sm:text-sm text-secondary-600 dark:text-gray-300">Đã phê duyệt</p>
                    <p class="text-lg sm:text-2xl font-bold text-secondary-900 dark:text-white">{{ \App\Models\Post::where('user_id', $user->id)->where('approval_status', 'approved')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-3 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center">
                <div class="w-8 h-8 sm:w-12 sm:h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center mx-auto sm:mx-0 mb-2 sm:mb-0 sm:mr-4">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-[10px] sm:text-sm text-secondary-600 dark:text-gray-300">Chờ duyệt</p>
                    <p class="text-lg sm:text-2xl font-bold text-secondary-900 dark:text-white">{{ \App\Models\Post::where('user_id', $user->id)->where('approval_status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-3 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center">
                <div class="w-8 h-8 sm:w-12 sm:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mx-auto sm:mx-0 mb-2 sm:mb-0 sm:mr-4">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-[10px] sm:text-sm text-secondary-600 dark:text-gray-300">Lượt xem</p>
                    <p class="text-lg sm:text-2xl font-bold text-secondary-900 dark:text-white">{{ \App\Models\Post::where('user_id', $user->id)->sum('view_count') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-4 sm:p-6 mb-6 sm:mb-8">
        <form method="GET" action="{{ route('profile.posts') }}" class="space-y-3 sm:space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-secondary-700 dark:text-gray-300 mb-1 sm:mb-2">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tiêu đề..." class="w-full px-3 sm:px-4 py-1.5 sm:py-2 text-sm sm:text-base border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Approval Filter -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-secondary-700 dark:text-gray-300 mb-1 sm:mb-2">Phê duyệt</label>
                    <select name="approval" class="w-full px-3 sm:px-4 py-1.5 sm:py-2 text-sm sm:text-base border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả</option>
                        <option value="approved" {{ request('approval') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="pending" {{ request('approval') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="rejected" {{ request('approval') == 'rejected' ? 'selected' : '' }}>Bị từ chối</option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-secondary-700 dark:text-gray-300 mb-1 sm:mb-2">Chuyên mục</label>
                    <select name="category" class="w-full px-3 sm:px-4 py-1.5 sm:py-2 text-sm sm:text-base border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-secondary-700 dark:text-gray-300 mb-1 sm:mb-2">Sắp xếp</label>
                    <select name="sort" class="w-full px-3 sm:px-4 py-1.5 sm:py-2 text-sm sm:text-base border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Xem nhiều nhất</option>
                        <option value="most_commented" {{ request('sort') == 'most_commented' ? 'selected' : '' }}>Nhiều bình luận nhất</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 sm:px-6 py-2 rounded-lg text-sm sm:text-base transition-colors duration-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Lọc
                </button>
                <a href="{{ route('profile.posts') }}" class="text-center sm:text-left text-sm sm:text-base text-secondary-600 dark:text-gray-400 hover:text-secondary-900 dark:hover:text-white">
                    Xóa bộ lọc
                </a>
            </div>
        </form>
    </div>

    <!-- View Toggle -->
    <div class="flex items-center justify-between mb-4 sm:mb-6">
        <h2 class="text-lg sm:text-2xl font-bold text-secondary-900 dark:text-white">
            {{ $posts->total() }} bài viết
        </h2>
        <div class="hidden lg:flex items-center space-x-2">
            <a href="{{ request()->fullUrlWithQuery(['view' => 'grid']) }}" class="p-2 rounded-lg {{ $viewMode == 'grid' ? 'bg-primary-600 text-white' : 'bg-secondary-200 dark:bg-gray-700 text-secondary-600 dark:text-gray-300' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            </a>
            <a href="{{ request()->fullUrlWithQuery(['view' => 'list']) }}" class="p-2 rounded-lg {{ $viewMode == 'list' ? 'bg-primary-600 text-white' : 'bg-secondary-200 dark:bg-gray-700 text-secondary-600 dark:text-gray-300' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </a>
        </div>
    </div>

    @if($posts->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-8 sm:p-12 text-center">
            <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-secondary-400 dark:text-gray-500 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-secondary-600 dark:text-gray-400 text-base sm:text-lg mb-3 sm:mb-4">Không tìm thấy bài viết nào</p>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tạo bài viết đầu tiên
            </a>
        </div>
    @else
        @if($viewMode == 'grid')
            <!-- Grid View -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                @foreach($posts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-40 sm:h-48 object-cover">
                        
                        <div class="p-4 sm:p-6">
                            <div class="flex items-center justify-between mb-2 sm:mb-3">
                                <span class="px-2 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold rounded-full {{ $post->category->is_active ? 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $post->category->name }}
                                </span>
                                @php
                                    $tagClasses = match($post->approval_status) {
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    };
                                    $tagText = match($post->approval_status) {
                                        'approved' => 'Đã duyệt',
                                        'pending' => 'Chờ duyệt',
                                        'rejected' => 'Bị từ chối',
                                        default => 'Không xác định',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold rounded-full {{ $tagClasses }}">
                                    {{ $tagText }}
                                </span>
                            </div>
                            
                            <h3 class="text-base sm:text-lg font-bold text-secondary-900 dark:text-white mb-1 sm:mb-2 line-clamp-2">
                                <a href="{{ route('posts.edit', $post) }}" class="hover:text-primary-600 dark:hover:text-primary-400">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            <p class="text-secondary-600 dark:text-gray-400 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">
                                {{ strip_tags($post->excerpt) }}
                            </p>
                            
                            <div class="flex items-center justify-between text-xs sm:text-sm text-secondary-500 dark:text-gray-400">
                                <div class="flex items-center space-x-2 sm:space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $post->view_count }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $post->comment_count }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-2 text-xs sm:text-sm">
                                    <a href="{{ route('posts.edit', $post) }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                        Chỉnh sửa
                                    </a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300" onclick="showConfirmationModal('Xác nhận xóa', 'Bạn có chắc chắn muốn xóa bài viết này?', 'Xóa', () => { this.closest('form').submit(); }, 'delete'); return false;">
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- List View -->
            <div class="hidden lg:block space-y-4 mb-8">
                @foreach($posts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-4 sm:p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-start space-x-3 sm:space-x-6">
                            <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-20 h-20 sm:w-32 sm:h-32 object-cover rounded-lg flex-shrink-0">
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center flex-wrap gap-2 mb-2">
                                    <span class="px-2 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                                        {{ $post->category->name }}
                                    </span>
                                    @php
                                        $tagClasses = match($post->approval_status) {
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        };
                                        $tagText = match($post->approval_status) {
                                            'approved' => 'Đã duyệt',
                                            'pending' => 'Chờ duyệt',
                                            'rejected' => 'Bị từ chối',
                                            default => 'Không xác định',
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold rounded-full {{ $tagClasses }}">
                                        {{ $tagText }}
                                    </span>
                                </div>
                                
                                <h3 class="text-base sm:text-xl font-bold text-secondary-900 dark:text-white mb-1 sm:mb-2 line-clamp-2">
                                    <a href="{{ route('posts.edit', $post) }}" class="hover:text-primary-600 dark:hover:text-primary-400">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                <p class="text-xs sm:text-sm text-secondary-600 dark:text-gray-400 mb-3 sm:mb-4 line-clamp-2">
                                    {{ strip_tags($post->excerpt) }}
                                </p>
                                
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs sm:text-sm text-secondary-500 dark:text-gray-400">
                                    <div class="flex items-center flex-wrap gap-2 sm:gap-4">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ $post->view_count }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            {{ $post->comment_count }}
                                        </span>
                                        <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('posts.edit', $post) }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium">
                                            Chỉnh sửa →
                                        </a>
                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium" onclick="showConfirmationModal('Xác nhận xóa', 'Bạn có chắc chắn muốn xóa bài viết này?', 'Xóa', () => { this.closest('form').submit(); }, 'delete'); return false;">
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Pagination -->
        <div class="mt-6 sm:mt-8">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
