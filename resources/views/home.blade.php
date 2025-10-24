@extends('layouts.app')

@section('title', 'Trang chủ - SmurfExpress')

@section('content')
<!-- Hero Carousel Section -->
<div class="mb-12">
    <div class="relative rounded-2xl overflow-hidden shadow-xl">
        <!-- Carousel Container -->
        <div class="relative" x-data="carousel()">
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
                    @foreach($posts->take(5) as $index => $post)
                        <div class="w-full flex-shrink-0">
                            <div class="relative h-96">
                                <!-- Background Image with Blur -->
                                @if($post->main_image)
                                    <div class="absolute inset-0">
                                        <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
                                    </div>
                                @else
                                    <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-100-dark dark:to-primary-200-dark">
                                        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                                    </div>
                                @endif
                                
                                <!-- Content Overlay -->
                                <div class="relative h-full flex items-center">
                                    <div class="container mx-auto px-6 lg:px-8">
                                        <div class="max-w-3xl text-white z-10">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 text-white mb-4">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                {{ $post->category->name }}
                                            </div>
                                            <h2 class="text-3xl lg:text-5xl font-bold mb-4 leading-tight">
                                                {{ Str::limit($post->title, 70) }}
                                            </h2>
                                            @if($post->excerpt)
                                                <p class="text-base lg:text-lg text-white text-opacity-90 mb-6 leading-relaxed">
                                                    {{ Str::limit($post->excerpt, 120) }}
                                                </p>
                                            @endif
                                            <div class="flex items-center space-x-4 mb-6 text-sm">
                                                <div class="flex items-center space-x-2">
                                                    @if($post->user->avatar)
                                                        <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-7 h-7 rounded-full object-cover border-2 border-white">
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
            
            <!-- Dots Indicator -->
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10">
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
<div x-data="{ viewMode: 'list' }">
    <!-- Section Header with View Toggle -->
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-primary-900 dark:text-primary-400-dark">Tin tức mới nhất</h1>
        
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

    <!-- Articles List View -->
    <div x-show="viewMode === 'list'" class="space-y-6">
        @forelse($posts as $index => $post)
            <article class="bg-white dark:bg-gray-800 rounded-lg border border-primary-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-900/20 transition-all duration-200 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    @if($post->main_image)
                        <div class="md:col-span-1 h-48 md:h-auto overflow-hidden">
                            <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        </div>
                    @endif
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
                                    <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500">
                                @else
                                    <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500">
                                @endif
                                <a href="{{ route('users.show', $post->user) }}" class="text-sm text-primary-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400-dark">{{ $post->user->name }}</a>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark text-sm font-medium">
                                Đọc tiếp →
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="text-center py-12">
                <p class="text-primary-500 dark:text-gray-400">Không có bài viết nào.</p>
            </div>
        @endforelse
    </div>

    <!-- Articles Grid View -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $index => $post)
            <article class="bg-white dark:bg-gray-800 rounded-lg border border-primary-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-900/20 transition-all duration-200 overflow-hidden flex flex-col">
                @if($post->main_image)
                    <div class="h-48 overflow-hidden flex-shrink-0">
                        <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                @endif
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
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500">
                            @else
                                <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-6 h-6 rounded-full object-cover border-2 border-primary-500">
                            @endif
                            <a href="{{ route('users.show', $post->user) }}" class="text-sm text-primary-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400-dark truncate">{{ $post->user->name }}</a>
                        </div>
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark text-sm font-medium">
                            →
                        </a>
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
            <nav class="flex items-center space-x-2">
                @if ($posts->onFirstPage())
                    <span class="px-3 py-2 text-sm text-primary-400 dark:text-gray-500 cursor-not-allowed">← Trước</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="px-3 py-2 text-sm text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark">← Trước</a>
                @endif

                @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                    @if ($page == $posts->currentPage())
                        <span class="px-3 py-2 text-sm bg-primary-900 dark:bg-primary-100-dark text-white dark:text-primary-900-dark rounded">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="px-3 py-2 text-sm text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark">Tiếp →</a>
                @else
                    <span class="px-3 py-2 text-sm text-primary-400 dark:text-gray-500 cursor-not-allowed">Tiếp →</span>
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
