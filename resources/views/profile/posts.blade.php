@extends('layouts.app')

@section('title', 'Bài viết của tôi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-900 rounded-xl shadow-lg p-8 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-heading font-bold text-white">Bài viết của tôi</h1>
                    <p class="text-primary-100 mt-2">Quản lý tất cả bài viết bạn đã tạo</p>
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
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-secondary-600 dark:text-gray-300">Tổng bài viết</p>
                    <p class="text-2xl font-bold text-secondary-900 dark:text-white">{{ $posts->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-secondary-600 dark:text-gray-300">Đã phê duyệt</p>
                    <p class="text-2xl font-bold text-secondary-900 dark:text-white">{{ \App\Models\Post::where('user_id', $user->id)->where('status', 'published')->where('approval_status', 'approved')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-secondary-600 dark:text-gray-300">Chờ duyệt</p>
                    <p class="text-2xl font-bold text-secondary-900 dark:text-white">{{ \App\Models\Post::where('user_id', $user->id)->where('status', 'published')->where('approval_status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-secondary-600 dark:text-gray-300">Lượt xem</p>
                    <p class="text-2xl font-bold text-secondary-900 dark:text-white">{{ \App\Models\Post::where('user_id', $user->id)->where('status', 'published')->sum('view_count') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 mb-8">
        <form method="GET" action="{{ route('profile.posts') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Tìm kiếm</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tiêu đề..." class="w-full px-4 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Trạng thái</label>
                    <select name="status" class="w-full px-4 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="" {{ !request('status') ? 'selected' : '' }}>Tất cả</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                    </select>
                </div>

                <!-- Approval Filter -->
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Phê duyệt</label>
                    <select name="approval" class="w-full px-4 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả</option>
                        <option value="approved" {{ request('approval') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="pending" {{ request('approval') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="rejected" {{ request('approval') == 'rejected' ? 'selected' : '' }}>Bị từ chối</option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Chuyên mục</label>
                    <select name="category" class="w-full px-4 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Sắp xếp</label>
                    <select name="sort" class="w-full px-4 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Xem nhiều nhất</option>
                        <option value="most_commented" {{ request('sort') == 'most_commented' ? 'selected' : '' }}>Nhiều bình luận nhất</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Lọc
                </button>
                <a href="{{ route('profile.posts') }}" class="text-secondary-600 dark:text-gray-400 hover:text-secondary-900 dark:hover:text-white">
                    Xóa bộ lọc
                </a>
            </div>
        </form>
    </div>

    <!-- View Toggle -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-secondary-900 dark:text-white">
            {{ $posts->total() }} bài viết
        </h2>
        <div class="flex items-center space-x-2">
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-secondary-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-secondary-600 dark:text-gray-400 text-lg mb-4">Không tìm thấy bài viết nào</p>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tạo bài viết đầu tiên
            </a>
        </div>
    @else
        @if($viewMode == 'grid')
            <!-- Grid View -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($posts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if($post->images->isNotEmpty())
                            <img src="{{ $post->images->first()->image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 flex items-center justify-center">
                                <svg class="w-16 h-16 text-primary-400 dark:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $post->category->is_active ? 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $post->category->name }}
                                </span>
                                @php
                                    $tagClasses = match(true) {
                                        $post->status == 'draft' && $post->approval_status == 'pending' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        $post->status == 'published' && $post->approval_status == 'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        $post->status == 'published' && $post->approval_status == 'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        $post->status == 'published' && $post->approval_status == 'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                    };
                                    $tagText = match(true) {
                                        $post->status == 'draft' && $post->approval_status == 'pending' => 'Bản nháp',
                                        $post->status == 'published' && $post->approval_status == 'approved' => 'Đã duyệt',
                                        $post->status == 'published' && $post->approval_status == 'pending' => 'Chờ duyệt',
                                        $post->status == 'published' && $post->approval_status == 'rejected' => 'Bị từ chối',
                                        default => 'Không xác định',
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $tagClasses }}">
                                    {{ $tagText }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-secondary-900 dark:text-white mb-2 line-clamp-2">
                                <a href="{{ route('posts.edit', $post) }}" class="hover:text-primary-600 dark:hover:text-primary-400">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            <p class="text-secondary-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ strip_tags($post->excerpt) }}
                            </p>
                            
                            <div class="flex items-center justify-between text-sm text-secondary-500 dark:text-gray-400">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $post->view_count }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $post->comment_count }}
                                    </span>
                                </div>
                                <a href="{{ route('posts.edit', $post) }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                    Chỉnh sửa
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- List View -->
            <div class="space-y-4 mb-8">
                @foreach($posts as $post)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-start space-x-6">
                            @if($post->images->isNotEmpty())
                                <img src="{{ $post->images->first()->image_url }}" alt="{{ $post->title }}" class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
                            @else
                                <div class="w-32 h-32 bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-12 h-12 text-primary-400 dark:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                                        {{ $post->category->name }}
                                    </span>
                                    @php
                                        $tagClasses = match(true) {
                                            $post->status == 'draft' && $post->approval_status == 'pending' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                            $post->status == 'published' && $post->approval_status == 'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            $post->status == 'published' && $post->approval_status == 'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            $post->status == 'published' && $post->approval_status == 'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        };
                                        $tagText = match(true) {
                                            $post->status == 'draft' && $post->approval_status == 'pending' => 'Bản nháp',
                                            $post->status == 'published' && $post->approval_status == 'approved' => 'Đã duyệt',
                                            $post->status == 'published' && $post->approval_status == 'pending' => 'Chờ duyệt',
                                            $post->status == 'published' && $post->approval_status == 'rejected' => 'Bị từ chối',
                                            default => 'Không xác định',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $tagClasses }}">
                                        {{ $tagText }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-secondary-900 dark:text-white mb-2">
                                    <a href="{{ route('posts.edit', $post) }}" class="hover:text-primary-600 dark:hover:text-primary-400">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                <p class="text-secondary-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    {{ strip_tags($post->excerpt) }}
                                </p>
                                
                                <div class="flex items-center justify-between text-sm text-secondary-500 dark:text-gray-400">
                                    <div class="flex items-center space-x-4">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ $post->view_count }} lượt xem
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            {{ $post->comment_count }} bình luận
                                        </span>
                                        <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <a href="{{ route('posts.edit', $post) }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium">
                                        Chỉnh sửa →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Pagination -->
        <div class="mt-8">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
