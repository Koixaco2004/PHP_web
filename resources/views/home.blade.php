@extends('layouts.app')

@section('title', 'Trang chủ - SmurfExpress')

@section('content')
<!-- Hero Carousel Section-->
<div class="relative w-screen left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] -mt-8 mb-12">
    <div class="relative overflow-hidden">
        <!-- Carousel Container -->
        <div class="relative" x-data="carousel()">
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
                    @foreach($posts->take(5) as $index => $post)
                        <div class="w-full flex-shrink-0">
                            <div class="relative h-[450px] md:h-[500px] lg:h-[550px]">
                                <!-- Background Image -->
                                <div class="absolute inset-0">
                                    <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    <!-- Gradient Overlay từ trái sang phải - Đậm hơn -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>
                                </div>
                                
                                <!-- Content Overlay -->
                                <div class="relative h-full flex items-center">
                                    <div class="container mx-auto px-8 sm:px-12 lg:px-20 xl:px-28">
                                        <div class="max-w-3xl text-white z-10">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 text-white mb-4">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                {{ $post->category->name }}
                                            </div>
                                            <h2 class="text-3xl lg:text-5xl font-bold mb-4 leading-snug lg:leading-snug">
                                                {{ Str::limit($post->title, 70) }}
                                            </h2>
                                            @if($post->excerpt)
                                                <p class="text-base lg:text-lg text-white text-opacity-90 mb-6 leading-relaxed line-clamp-2">
                                                    {{ Str::limit($post->excerpt, 120) }}
                                                </p>
                                            @endif
                                            <div class="flex items-center space-x-4 mb-6 text-sm">
                                                <div class="flex items-center space-x-2">
                                                    @if($post->user->avatar)
                                                        @if(Str::startsWith($post->user->avatar, ['http://', 'https://']))
                                                            <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="w-7 h-7 rounded-full object-cover border-2 border-white" onerror="this.src='{{ asset('hello.png') }}'">
                                                        @else
                                                            <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-7 h-7 rounded-full object-cover border-2 border-white" onerror="this.src='{{ asset('hello.png') }}'">
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-7 h-7 rounded-full object-cover border-2 border-white">
                                                    @endif
                                                    <a href="{{ route('users.show', $post->user) }}" class="text-white text-opacity-90 hover:text-white hover:underline">{{ $post->user->name }}</a>
                                                </div>
                                                <div class="flex items-center text-white text-opacity-75">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $post->approved_at ? $post->approved_at->diffForHumans() : $post->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center px-6 py-3 bg-white text-primary-700 dark:bg-gray-800 dark:text-primary-400-dark font-semibold rounded-lg hover:bg-primary-50 dark:hover:bg-gray-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                                Đọc ngay
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button @click="prevSlide()"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-3 rounded-full transition-all duration-200 z-20 focus:outline-none focus:ring-2 focus:ring-white"
                    aria-label="Previous slide">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="nextSlide()"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white p-3 rounded-full transition-all duration-200 z-20 focus:outline-none focus:ring-2 focus:ring-white"
                    aria-label="Next slide">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <!-- Dots Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                @foreach($posts->take(5) as $index => $post)
                    <button @click="currentSlide = {{ $index }}" 
                            class="w-3 h-3 rounded-full transition-all duration-200 shadow-lg"
                            :class="currentSlide === {{ $index }} ? 'bg-white scale-110' : 'bg-white bg-opacity-50 hover:bg-opacity-75'">
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div>
    <!-- Section Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-primary-900 dark:text-primary-400-dark">Tin tức mới nhất</h1>
    </div>

    <!-- Articles Grid View -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
            </article>
        @empty
            <div class="text-center py-12 col-span-full">
                <p class="text-primary-500 dark:text-gray-400">Không có bài viết nào.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="mt-8 flex justify-center">
            <nav class="flex flex-wrap items-center justify-center gap-2">
                @if ($posts->onFirstPage())
                    <span class="px-2 sm:px-3 py-2 text-xs sm:text-sm text-primary-400 dark:text-gray-500 cursor-not-allowed">← Trước</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="px-2 sm:px-3 py-2 text-xs sm:text-sm text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark">← Trước</a>
                @endif

                @php
                    $currentPage = $posts->currentPage();
                    $lastPage = $posts->lastPage();
                    $start = max(1, $currentPage - 1);
                    $end = min($lastPage, $currentPage + 1);
                    
                    // Always show first page
                    $pages = [1];
                    
                    // Add second page if exists and needed
                    if ($lastPage >= 2 && $start > 2) {
                        $pages[] = 2;
                    }
                    
                    // Add ellipsis or pages after first pages
                    if ($start > 3) {
                        $pages[] = '...';
                    }
                    
                    // Add middle pages
                    for ($i = $start; $i <= $end; $i++) {
                        if ($i > 2 && $i < $lastPage - 1) {
                            $pages[] = $i;
                        } elseif ($i == 2 && $start <= 2) {
                            $pages[] = $i;
                        } elseif ($i == $lastPage - 1 && $end >= $lastPage - 1) {
                            $pages[] = $i;
                        }
                    }
                    
                    // Add ellipsis or pages before last pages
                    if ($end < $lastPage - 2) {
                        $pages[] = '...';
                    }
                    
                    // Add second to last page if exists and needed
                    if ($lastPage >= 2 && $end < $lastPage - 1) {
                        $pages[] = $lastPage - 1;
                    }
                    
                    // Always show last page if there's more than 1 page
                    if ($lastPage > 1) {
                        $pages[] = $lastPage;
                    }
                @endphp

                @foreach ($pages as $page)
                    @if ($page === '...')
                        <span class="px-2 sm:px-3 py-2 text-xs sm:text-sm text-primary-400 dark:text-gray-500">...</span>
                    @elseif ($page == $currentPage)
                        <span class="px-2 sm:px-3 py-2 text-xs sm:text-sm bg-primary-900 dark:bg-primary-100-dark text-white dark:text-primary-900-dark rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $posts->url($page) }}" class="px-2 sm:px-3 py-2 text-xs sm:text-sm text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="px-2 sm:px-3 py-2 text-xs sm:text-sm text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark">Tiếp →</a>
                @else
                    <span class="px-2 sm:px-3 py-2 text-xs sm:text-sm text-primary-400 dark:text-gray-500 cursor-not-allowed">Tiếp →</span>
                @endif
            </nav>
        </div>
    @endif
</div>

@endsection

<script>
function carousel() {
    return {
        currentSlide: 0,
        totalSlides: {{ $posts->take(5)->count() }},
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        
        prevSlide() {
            this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
        },
        
        init() {
            setInterval(() => {
                this.nextSlide();
            }, 5000);
        }
    }
}

</script>
