@extends('layouts.app')

@section('title', 'Trang chủ - Website Tin Tức')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-8 mb-8 animate-fade-in">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-heading font-bold text-secondary-900 mb-4">
            Tin Tức <span class="text-primary-600">24h</span>
        </h1>
        <p class="text-lg text-secondary-600 mb-8">
            Cập nhật những tin tức mới nhất, chính xác và đáng tin cậy từ mọi lĩnh vực
        </p>
        
        <!-- Advanced Search Section -->
        <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 max-w-3xl mx-auto">
            <form method="GET" action="{{ route('home') }}" class="space-y-4 md:space-y-0 md:flex md:gap-4">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" 
                               class="block w-full pl-10 pr-3 py-2.5 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" 
                               placeholder="Tìm kiếm bài viết..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                
                <div class="md:w-48">
                    <select name="category" 
                            class="block w-full px-3 py-2.5 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                        <option value="">Tất cả chuyên mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn-primary px-6 py-2.5 whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Tìm kiếm
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Main Articles Section -->
    <div class="lg:col-span-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-heading font-bold text-secondary-900">Tin tức mới nhất</h2>
            <div class="flex items-center text-sm text-secondary-500">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Cập nhật {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="space-y-6">
            @forelse($posts as $index => $post)
                @if($index === 0)
                    <!-- Featured Article (First Post) -->
                    <article class="card overflow-hidden animate-slide-up">
                        <div class="md:flex">
                            <div class="md:w-1/3">
                                <div class="h-64 md:h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3v9M9 3h6v3H9V3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="md:w-2/3 p-6">
                                <div class="flex items-center mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                        Nổi bật
                                    </span>
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl md:text-2xl font-heading font-bold text-secondary-900 mb-3 line-clamp-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary-600 transition-colors duration-200">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                @if($post->excerpt)
                                    <p class="text-secondary-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-secondary-500 space-x-4">
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center mr-2">
                                                <span class="text-xs font-medium text-primary-600">{{ substr($post->user->name, 0, 1) }}</span>
                                            </div>
                                            {{ $post->user->name }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $post->created_at->format('d/m/Y') }}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ $post->view_count }}
                                        </div>
                                    </div>
                                    <a href="{{ route('posts.show', $post->slug) }}" class="btn-primary text-sm px-4 py-2">
                                        Đọc tiếp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @else
                    <!-- Regular Article Cards -->
                    <article class="card p-6 hover:shadow-md transition-shadow duration-300 animate-slide-up" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="flex items-start space-x-4">
                            <div class="w-20 h-20 bg-gradient-to-br from-secondary-100 to-secondary-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center mb-2">
                                    <a href="{{ route('categories.show', $post->category) }}" 
                                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-accent-100 text-accent-800 hover:bg-accent-200 transition-colors duration-200">
                                        {{ $post->category->name }}
                                    </a>
                                </div>
                                
                                <h3 class="text-lg font-heading font-semibold text-secondary-900 mb-2 line-clamp-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary-600 transition-colors duration-200">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                @if($post->excerpt)
                                    <p class="text-secondary-600 text-sm mb-3 line-clamp-2">{{ $post->excerpt }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-xs text-secondary-500 space-x-3">
                                        <div class="flex items-center">
                                            <div class="w-5 h-5 bg-primary-100 rounded-full flex items-center justify-center mr-1.5">
                                                <span class="text-xs font-medium text-primary-600">{{ substr($post->user->name, 0, 1) }}</span>
                                            </div>
                                            {{ $post->user->name }}
                                        </div>
                                        <span>•</span>
                                        <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $post->view_count }} lượt xem</span>
                                    </div>
                                    
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm transition-colors duration-200">
                                        Đọc tiếp →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endif
            @empty
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-secondary-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-secondary-900 mb-2">Không có bài viết nào</h3>
                    <p class="text-secondary-500">Không tìm thấy bài viết nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($posts->onFirstPage())
                        <span class="px-3 py-2 text-sm text-secondary-400 bg-secondary-100 rounded-lg cursor-not-allowed">
                            ← Trước
                        </span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}" class="px-3 py-2 text-sm text-secondary-600 bg-white border border-secondary-200 rounded-lg hover:bg-secondary-50 transition-colors duration-200">
                            ← Trước
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <span class="px-3 py-2 text-sm bg-primary-600 text-white rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 text-sm text-secondary-600 bg-white border border-secondary-200 rounded-lg hover:bg-secondary-50 transition-colors duration-200">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="px-3 py-2 text-sm text-secondary-600 bg-white border border-secondary-200 rounded-lg hover:bg-secondary-50 transition-colors duration-200">
                            Tiếp →
                        </a>
                    @else
                        <span class="px-3 py-2 text-sm text-secondary-400 bg-secondary-100 rounded-lg cursor-not-allowed">
                            Tiếp →
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-4 space-y-6">
        <!-- Categories Widget -->
        <div class="card animate-slide-up" style="animation-delay: 0.2s">
            <div class="card-header">
                <h3 class="text-lg font-heading font-semibold text-secondary-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Chuyên mục
                </h3>
            </div>
            <div class="card-body">
                <div class="space-y-2">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category) }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-secondary-50 transition-colors duration-200 group">
                            <span class="text-secondary-700 group-hover:text-primary-600 font-medium">{{ $category->name }}</span>
                            <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Stats Widget -->
        <div class="card animate-slide-up" style="animation-delay: 0.3s">
            <div class="card-header">
                <h3 class="text-lg font-heading font-semibold text-secondary-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Thống kê
                </h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-primary-50 rounded-lg">
                        <div class="text-2xl font-bold text-primary-600">{{ $posts->total() }}</div>
                        <div class="text-sm text-primary-700 font-medium">Tổng bài viết</div>
                    </div>
                    <div class="text-center p-4 bg-accent-50 rounded-lg">
                        <div class="text-2xl font-bold text-accent-600">{{ $categories->count() }}</div>
                        <div class="text-sm text-accent-700 font-medium">Chuyên mục</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Widget -->
        <div class="card bg-gradient-to-br from-primary-500 to-primary-600 text-white animate-slide-up" style="animation-delay: 0.4s">
            <div class="card-body">
                <h3 class="text-lg font-heading font-semibold mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Nhận tin mới
                </h3>
                <p class="text-primary-100 mb-4 text-sm">Đăng ký để nhận thông báo tin tức mới nhất</p>
                <form class="space-y-3">
                    <input type="email" placeholder="Email của bạn..." 
                           class="w-full px-3 py-2 rounded-lg text-secondary-900 placeholder-secondary-400 focus:ring-2 focus:ring-primary-300 focus:ring-offset-2 focus:ring-offset-primary-500">
                    <button type="submit" class="w-full bg-white text-primary-600 font-medium py-2 rounded-lg hover:bg-primary-50 transition-colors duration-200">
                        Đăng ký ngay
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles for line-clamp -->
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
