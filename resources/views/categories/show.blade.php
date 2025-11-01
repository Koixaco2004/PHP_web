@extends('layouts.app')

@section('title', $category->name)

@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 dark:text-gray-400 mb-6">
    <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 dark:text-gray-300 font-medium">{{ $category->name }}</span>
</nav>

<!-- Category Header -->
<div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900 dark:to-primary-800 rounded-2xl p-8 mb-8">
    <div class="max-w-4xl">
        <div class="flex items-center space-x-3 mb-4">
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

<div x-data="{ viewMode: 'grid' }">
    <!-- Section Header with View Toggle and Sort -->
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <h2 class="text-2xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark">Bài viết trong chuyên mục</h2>
        
        <div class="flex items-center space-x-4">
            <!-- Sort Options -->
            <div class="flex items-center space-x-2">
                <label class="text-sm text-secondary-600 dark:text-gray-300">Sắp xếp:</label>
                <select onchange="window.location.href='{{ route('categories.show', $category) }}?sort=' + this.value" class="text-sm border border-secondary-300 dark:border-gray-600 rounded-lg px-3 py-1.5 bg-white dark:bg-gray-700 text-secondary-900 dark:text-primary-400-dark focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark transition-colors duration-200">
                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                    <option value="most_viewed" {{ $sort == 'most_viewed' ? 'selected' : '' }}>Nhiều lượt xem</option>
                </select>
            </div>
            
            <!-- View Mode Toggle -->
            <div class="flex items-center space-x-2 bg-white dark:bg-gray-800 rounded-lg border border-primary-200 dark:border-gray-700 p-1">
                <button @click="viewMode = 'list'" 
                        :class="viewMode === 'list' ? 'bg-primary-600 text-white dark:bg-primary-500' : 'text-primary-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-300-dark'"
                        class="p-2 rounded transition-all duration-200"
                        title="Xem dạng danh sách">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <button @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-primary-600 text-white dark:bg-primary-500' : 'text-primary-600 dark:text-gray-400 hover:text-primary-900 dark:hover:text-primary-300-dark'"
                        class="p-2 rounded transition-all duration-200"
                        title="Xem dạng lưới">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Articles List View -->
    <div x-show="viewMode === 'list'" class="space-y-6">
        @forelse($posts as $index => $post)
            <article class="bg-white dark:bg-gray-800 rounded-lg border border-primary-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-900/20 transition-all duration-200 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    <div class="md:col-span-1 h-48 md:h-auto overflow-hidden">
                        <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="md:col-span-2 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-medium text-primary-600 dark:text-primary-400-dark bg-primary-50 dark:bg-primary-900-dark px-2 py-1 rounded">
                                {{ $post->category->name }}
                            </span>
                            <span class="text-xs text-primary-500 dark:text-gray-400">{{ $post->approved_at ? $post->approved_at->diffForHumans() : $post->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <h2 class="text-lg font-semibold text-primary-900 dark:text-primary-400-dark mb-3 leading-tight">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary-700 dark:hover:text-primary-300-dark">
                                {{ $post->title }}
                            </a>
                        </h2>
                        
                        @if($post->excerpt)
                            <p class="text-primary-600 dark:text-gray-300 mb-4 line-clamp-2 text-sm leading-relaxed">{{ $post->excerpt }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between pt-3 border-t border-primary-100 dark:border-gray-700">
                            <div class="flex items-center space-x-2">
                                @if($post->user->avatar)
                                    @if(Str::startsWith($post->user->avatar, ['http://', 'https://']))
                                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500" onerror="this.src='{{ asset('hello.png') }}'">
                                    @else
                                        <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500" onerror="this.src='{{ asset('hello.png') }}'">
                                    @endif
                                @else
                                    <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500">
                                @endif
                                <a href="{{ route('users.show', $post->user) }}" class="text-sm text-primary-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400-dark">{{ $post->user->name }}</a>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center text-primary-500 dark:text-gray-400 text-xs">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ number_format($post->view_count) }}
                                </div>
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark text-sm font-medium">
                                    Đọc tiếp →
                                </a>
                            </div>
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

    <!-- Articles Grid View -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $index => $post)
            <article class="bg-white dark:bg-gray-800 rounded-lg border border-primary-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-900/20 transition-all duration-200 overflow-hidden flex flex-col">
                <div class="h-48 overflow-hidden flex-shrink-0">
                    <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-medium text-primary-600 dark:text-primary-400-dark bg-primary-50 dark:bg-primary-900-dark px-2 py-1 rounded">
                            {{ $post->category->name }}
                        </span>
                        <span class="text-xs text-primary-500 dark:text-gray-400">{{ $post->approved_at ? $post->approved_at->diffForHumans() : $post->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <h2 class="text-base font-semibold text-primary-900 dark:text-primary-400-dark mb-2 leading-tight">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary-700 dark:hover:text-primary-300-dark">
                            {{ Str::limit($post->title, 60) }}
                        </a>
                    </h2>
                    
                    @if($post->excerpt)
                        <p class="text-primary-600 dark:text-gray-300 mb-4 line-clamp-2 text-sm leading-relaxed flex-grow">{{ Str::limit($post->excerpt, 80) }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-3 border-t border-primary-100 dark:border-gray-700 mt-auto">
                        <div class="flex items-center space-x-2">
                            @if($post->user->avatar)
                                @if(Str::startsWith($post->user->avatar, ['http://', 'https://']))
                                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500" onerror="this.src='{{ asset('hello.png') }}'">
                                @else
                                    <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500" onerror="this.src='{{ asset('hello.png') }}'">
                                @endif
                            @else
                                <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500">
                            @endif
                            <a href="{{ route('users.show', $post->user) }}" class="text-sm text-primary-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400-dark truncate">{{ $post->user->name }}</a>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center text-primary-500 dark:text-gray-400 text-xs">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($post->view_count) }}
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark text-sm font-medium">
                                →
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
            </article>
        @empty
            <!-- Empty State -->
            <div class="text-center py-16 col-span-full">
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
@endsection