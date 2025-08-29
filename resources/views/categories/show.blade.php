@extends('layouts.app')

@section('title', $category->name)

@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 mb-6 animate-fade-in">
    <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 font-medium">{{ $category->name }}</span>
</nav>

<!-- Category Header -->
<div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-8 mb-8 animate-slide-up">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-heading font-bold text-secondary-900">
                        {{ $category->name }}
                    </h1>
                    <div class="flex items-center mt-2 text-secondary-600 space-x-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ $posts->total() }} bài viết
                        </div>
                        <span>•</span>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Cập nhật {{ $posts->count() > 0 ? $posts->first()->created_at->format('d/m/Y') : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Category Stats -->
            <div class="hidden md:flex items-center space-x-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary-600">{{ $posts->total() }}</div>
                    <div class="text-sm text-secondary-600">Bài viết</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-accent-600">{{ $posts->sum('view_count') }}</div>
                    <div class="text-sm text-secondary-600">Lượt xem</div>
                </div>
            </div>
        </div>
        
        @if($category->description)
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4 border border-white/50">
                <p class="text-secondary-700 leading-relaxed">{{ $category->description }}</p>
            </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Main Articles Section -->
    <div class="lg:col-span-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-heading font-bold text-secondary-900">Bài viết trong chuyên mục</h2>
            
            <!-- Sort Options -->
            <div class="flex items-center space-x-2">
                <label class="text-sm text-secondary-600">Sắp xếp:</label>
                <select class="text-sm border border-secondary-300 rounded-lg px-3 py-1.5 bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                    <option>Mới nhất</option>
                    <option>Cũ nhất</option>
                    <option>Nhiều lượt xem</option>
                </select>
            </div>
        </div>

        <!-- Articles List -->
        <div class="space-y-6">
            @forelse($posts as $index => $post)
                <article class="bg-white rounded-lg border border-primary-200 overflow-hidden p-6 hover:shadow-md transition-all duration-300 animate-slide-up group" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex space-x-6">
                        <!-- Article Thumbnail -->
                        <div class="w-32 h-24 bg-gradient-to-br from-secondary-100 to-secondary-200 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:from-primary-100 group-hover:to-primary-200 transition-all duration-300">
                            <svg class="w-8 h-8 text-secondary-400 group-hover:text-primary-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        
                        <!-- Article Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    Bài viết
                                </span>
                                <div class="flex items-center text-xs text-secondary-500 space-x-3">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $post->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ $post->view_count }}
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-heading font-semibold text-secondary-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors duration-300">
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            @if($post->excerpt)
                                <p class="text-secondary-600 text-sm mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-primary-600">{{ substr($post->user->name, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-secondary-600">{{ $post->user->name }}</span>
                                </div>
                                
                                <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium text-sm transition-colors duration-200 group-hover:translate-x-1 transform">
                                    Đọc tiếp
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-heading font-semibold text-secondary-900 mb-2">Chưa có bài viết nào</h3>
                    <p class="text-secondary-500 mb-6">Chuyên mục này hiện chưa có bài viết nào được đăng.</p>
                    <a href="{{ route('home') }}" class="btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                        </svg>
                        Quay về trang chủ
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($posts->onFirstPage())
                        <span class="px-4 py-2 text-sm text-secondary-400 bg-secondary-100 rounded-lg cursor-not-allowed">
                            ← Trước
                        </span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}" class="px-4 py-2 text-sm text-secondary-600 bg-white border border-secondary-200 rounded-lg hover:bg-secondary-50 transition-colors duration-200">
                            ← Trước
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <span class="px-4 py-2 text-sm bg-primary-600 text-white rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 text-sm text-secondary-600 bg-white border border-secondary-200 rounded-lg hover:bg-secondary-50 transition-colors duration-200">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="px-4 py-2 text-sm text-secondary-600 bg-white border border-secondary-200 rounded-lg hover:bg-secondary-50 transition-colors duration-200">
                            Tiếp →
                        </a>
                    @else
                        <span class="px-4 py-2 text-sm text-secondary-400 bg-secondary-100 rounded-lg cursor-not-allowed">
                            Tiếp →
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-4 space-y-6">
        <!-- Category Info -->
        <div class="bg-white rounded-lg border border-primary-200 overflow-hidden hover:shadow-sm transition-all duration-200 animate-slide-up" style="animation-delay: 0.2s">
            <div class="p-6 border-b border-secondary-200 bg-secondary-50">
                <h3 class="text-lg font-heading font-semibold text-secondary-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Thông tin chuyên mục
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between p-3 bg-primary-50 rounded-lg">
                    <span class="text-secondary-700 font-medium">Tổng bài viết</span>
                    <span class="text-2xl font-bold text-primary-600">{{ $posts->total() }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-accent-50 rounded-lg">
                    <span class="text-secondary-700 font-medium">Tổng lượt xem</span>
                    <span class="text-2xl font-bold text-accent-600">{{ $posts->sum('view_count') }}</span>
                </div>
                
                @if($category->description)
                    <div class="p-4 bg-secondary-50 rounded-lg">
                        <h4 class="font-semibold text-secondary-900 mb-2">Mô tả</h4>
                        <p class="text-secondary-600 text-sm leading-relaxed">{{ $category->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="bg-white rounded-lg border border-primary-200 overflow-hidden hover:shadow-sm transition-all duration-200 animate-slide-up" style="animation-delay: 0.3s">
            <div class="p-6 border-b border-secondary-200 bg-secondary-50">
                <h3 class="text-lg font-heading font-semibold text-secondary-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Điều hướng nhanh
                </h3>
            </div>
            <div class="p-6">
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center justify-between p-3 rounded-lg hover:bg-secondary-50 transition-colors duration-200 group">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary-500 mr-3 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="text-secondary-700 group-hover:text-primary-600 font-medium">Trang chủ</span>
                        </div>
                        <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    
                    <a href="{{ route('home') }}#categories" class="flex items-center justify-between p-3 rounded-lg hover:bg-secondary-50 transition-colors duration-200 group">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary-500 mr-3 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span class="text-secondary-700 group-hover:text-primary-600 font-medium">Tất cả chuyên mục</span>
                        </div>
                        <svg class="w-4 h-4 text-secondary-400 group-hover:text-primary-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Back to Top -->
        <div class="sticky top-8">
            <button id="backToTop" class="w-full btn-secondary flex items-center justify-center opacity-0 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                </svg>
                Về đầu trang
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Back to top functionality
    const backToTopBtn = document.getElementById('backToTop');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTopBtn.classList.remove('opacity-0');
            backToTopBtn.classList.add('opacity-100');
        } else {
            backToTopBtn.classList.add('opacity-0');
            backToTopBtn.classList.remove('opacity-100');
        }
    });

    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>
@endsection
