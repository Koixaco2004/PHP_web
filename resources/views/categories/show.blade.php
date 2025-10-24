@extends('layouts.app')

@section('title', $category->name)

@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 dark:text-gray-400 mb-6 animate-fade-in">
    <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 dark:text-gray-300 font-medium">{{ $category->name }}</span>
</nav>

<!-- Category Header -->
<div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900 dark:to-primary-800 rounded-2xl p-8 mb-8 animate-slide-up">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-heading font-bold text-secondary-900 dark:text-primary-100">
                        {{ $category->name }}
                    </h1>
                    <div class="flex items-center mt-2 text-secondary-600 dark:text-primary-200 space-x-4">
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
                    <div class="text-2xl font-bold text-primary-600 dark:text-primary-300">{{ $posts->total() }}</div>
                    <div class="text-sm text-secondary-600 dark:text-primary-200">Bài viết</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-accent-600 dark:text-accent-400">{{ $posts->sum('view_count') }}</div>
                    <div class="text-sm text-secondary-600 dark:text-primary-200">Lượt xem</div>
                </div>
            </div>
        </div>
        
        @if($category->description)
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-xl p-4 border border-white/50 dark:border-gray-700/50">
                <p class="text-secondary-700 dark:text-gray-300 leading-relaxed">{{ $category->description }}</p>
            </div>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Main Articles Section -->
    <div class="lg:col-span-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark">Bài viết trong chuyên mục</h2>
            
            <!-- Sort Options -->
            <div class="flex items-center space-x-2">
                <label class="text-sm text-secondary-600 dark:text-gray-300">Sắp xếp:</label>
                <select class="text-sm border border-secondary-300 dark:border-gray-600 rounded-lg px-3 py-1.5 bg-white dark:bg-gray-700 text-secondary-900 dark:text-primary-400-dark focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark transition-colors duration-200">
                    <option>Mới nhất</option>
                    <option>Cũ nhất</option>
                    <option>Nhiều lượt xem</option>
                </select>
            </div>
        </div>

        <!-- Articles List -->
        <div class="space-y-6">
            @forelse($posts as $index => $post)
                <article class="bg-white dark:bg-gray-800 rounded-lg border border-primary-200 dark:border-gray-700 overflow-hidden p-6 hover:shadow-md dark:hover:shadow-gray-900/20 transition-all duration-300 animate-slide-up group" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="flex space-x-6">
                        <!-- Article Thumbnail -->
                        <div class="w-32 h-24 bg-gradient-to-br from-secondary-100 dark:from-gray-700 to-secondary-200 dark:to-gray-600 rounded-lg overflow-hidden flex-shrink-0 group-hover:shadow-md transition-all duration-300">
                            @if($post->main_image)
                                <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-secondary-100 dark:from-gray-700 to-secondary-200 dark:to-gray-600 group-hover:from-primary-100 dark:group-hover:from-primary-900 group-hover:to-primary-200 dark:group-hover:to-primary-800 transition-all duration-300">
                                    <svg class="w-8 h-8 text-secondary-400 dark:text-gray-500 group-hover:text-primary-500 dark:group-hover:text-primary-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Article Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-400-dark">
                                    Bài viết
                                </span>
                                <div class="flex items-center text-xs text-secondary-500 dark:text-gray-400 space-x-3">
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
                            
                            <h3 class="text-xl font-heading font-semibold text-secondary-900 dark:text-primary-400-dark mb-3 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">
                                <a href="{{ route('posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            @if($post->excerpt)
                                <p class="text-secondary-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">{{ $post->excerpt }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-6 h-6 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-primary-600 dark:text-primary-400">{{ substr($post->user->name, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-secondary-600 dark:text-gray-300">{{ $post->user->name }}</span>
                                </div>
                                
                                <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium text-sm transition-colors duration-200 group-hover:translate-x-1 transform">
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
                    <div class="w-20 h-20 bg-secondary-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-heading font-semibold text-secondary-900 dark:text-primary-400-dark mb-2">Chưa có bài viết nào</h3>
                    <p class="text-secondary-500 dark:text-gray-400 mb-6">Chuyên mục này hiện chưa có bài viết nào được đăng.</p>
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
                        <span class="px-4 py-2 text-sm text-secondary-400 dark:text-gray-500 bg-secondary-100 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                            ← Trước
                        </span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}" class="px-4 py-2 text-sm text-secondary-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-200 dark:border-gray-600 rounded-lg hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            ← Trước
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <span class="px-4 py-2 text-sm bg-primary-600 text-white rounded-lg">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 text-sm text-secondary-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-200 dark:border-gray-600 rounded-lg hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="px-4 py-2 text-sm text-secondary-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-200 dark:border-gray-600 rounded-lg hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            Tiếp →
                        </a>
                    @else
                        <span class="px-4 py-2 text-sm text-secondary-400 dark:text-gray-500 bg-secondary-100 dark:bg-gray-700 rounded-lg cursor-not-allowed">
                            Tiếp →
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-4">
        <!-- Category Info -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 mb-6 animate-slide-up" style="animation-delay: 0.2s">
            <div class="flex items-center mb-4">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-heading font-semibold text-secondary-900 dark:text-primary-400-dark">Thông tin chuyên mục</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between py-2 border-b border-secondary-100 dark:border-gray-700">
                    <span class="text-secondary-600 dark:text-gray-300">Tổng bài viết</span>
                    <span class="font-semibold text-secondary-900 dark:text-primary-400-dark">{{ $posts->total() }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-secondary-100 dark:border-gray-700">
                    <span class="text-secondary-600 dark:text-gray-300">Tổng lượt xem</span>
                    <span class="font-semibold text-secondary-900 dark:text-primary-400-dark">{{ number_format($posts->sum('view_count')) }}</span>
                </div>
            </div>
        </div>

        <!-- Related Categories -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.4s">
            <div class="flex items-center mb-4">
                <svg class="w-5 h-5 text-accent-600 dark:text-accent-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <h3 class="text-lg font-heading font-semibold text-secondary-900 dark:text-primary-400-dark">Chuyên mục khác</h3>
            </div>
            
            <div class="space-y-3">
                @php
                    $otherCategories = \App\Models\Category::where('id', '!=', $category->id)->withCount('posts')->take(5)->get();
                @endphp
                
                @foreach($otherCategories as $otherCategory)
                    <a href="{{ route('categories.show', $otherCategory) }}" class="flex items-center justify-between p-3 rounded-lg hover:bg-accent-50 dark:hover:bg-accent-900/20 transition-colors duration-200 group">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-accent-600 dark:text-accent-400 mr-2 group-hover:text-accent-700 dark:group-hover:text-accent-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="text-secondary-700 dark:text-gray-300 group-hover:text-accent-700 dark:group-hover:text-accent-300 font-medium">{{ $otherCategory->name }}</span>
                        </div>
                        <span class="text-xs text-secondary-500 dark:text-gray-400 bg-secondary-100 dark:bg-gray-700 px-2 py-1 rounded-full">{{ $otherCategory->posts_count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection