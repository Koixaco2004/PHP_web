@extends('layouts.app')

@section('title', 'Trang chủ - Website Tin Tức')

@section('content')
<!-- Hero Carousel Section -->
<div class="mb-12">
    <div class="relative bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>

        <!-- Carousel Container -->
        <div class="relative" x-data="carousel()">
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-500 ease-in-out"
                    :style="`transform: translateX(-${currentSlide * 100}%)`">
                    @foreach($posts->take(5) as $index => $post)
                    <div class="w-full flex-shrink-0">
                        <div class="relative h-96 flex items-center">
                            <div class="container mx-auto px-6 lg:px-8">
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                                    <div class="lg:col-span-5 hidden lg:block">
                                        <div
                                            class="w-full h-80 bg-white bg-opacity-10 rounded-xl overflow-hidden backdrop-blur-sm shadow-2xl">
                                            @if($post->main_image)
                                            <img src="{{ $post->main_image }}" alt="{{ $post->title }}"
                                                class="w-full h-full object-cover">
                                            @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-20 h-20 text-white text-opacity-50" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="lg:col-span-7 text-white z-10 pl-8">
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white mb-4">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            {{ $post->category->name }}
                                        </div>
                                        <h2 class="text-2xl lg:text-3xl font-bold mb-4 leading-tight">
                                            {{ Str::limit($post->title, 70) }}
                                        </h2>
                                        @if($post->excerpt)
                                        <p class="text-base text-white text-opacity-90 mb-6 leading-relaxed">
                                            {{ Str::limit($post->excerpt, 120) }}
                                        </p>
                                        @endif
                                        <div class="flex items-center space-x-4 mb-6 text-sm">
                                            <div class="flex items-center space-x-2">
                                                <div
                                                    class="w-7 h-7 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                                    <span
                                                        class="text-xs font-semibold text-white">{{ substr($post->user->name, 0, 1) }}</span>
                                                </div>
                                                <span class="text-white text-opacity-90">{{ $post->user->name }}</span>
                                            </div>
                                            <div class="flex items-center text-white text-opacity-75">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $post->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                        <a href="{{ route('posts.show', $post->slug) }}"
                                            class="inline-flex items-center px-6 py-3 bg-white text-primary-700 font-semibold rounded-lg hover:bg-primary-50 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                            Đọc ngay
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
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
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2">
                @foreach($posts->take(5) as $index => $post)
                <button @click="currentSlide = {{ $index }}" class="w-3 h-3 rounded-full transition-all duration-200"
                    :class="currentSlide === {{ $index }} ? 'bg-white' : 'bg-white bg-opacity-50'">
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Articles Section -->
    <div class="lg:col-span-2">
        <!-- Section Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-primary-900 mb-6">Tin tức mới nhất</h1>
        </div>



        <!-- Articles Grid -->
        <div class="space-y-6">
            @forelse($posts as $index => $post)
            <!-- Clean Article Cards -->
            <article
                class="bg-white rounded-lg border border-primary-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                    @if($post->main_image)
                    <div class="md:col-span-1 h-48 md:h-auto overflow-hidden">
                        <img src="{{ $post->main_image }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    @endif
                    <div class="md:col-span-2 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                                {{ $post->category->name }}
                            </span>
                            <span class="text-xs text-primary-500">{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        <h2 class="text-lg font-semibold text-primary-900 mb-3 leading-tight">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary-700">
                                {{ $post->title }}
                            </a>
                        </h2>

                        @if($post->excerpt)
                        <p class="text-primary-600 mb-4 line-clamp-2 text-sm leading-relaxed">{{ $post->excerpt }}</p>
                        @endif

                        <div class="flex items-center justify-between pt-3 border-t border-primary-100">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-primary-900 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-xs font-semibold text-white">{{ substr($post->user->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm text-primary-700">{{ $post->user->name }}</span>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}"
                                class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                Đọc tiếp →
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="text-center py-12">
                <p class="text-primary-500">Không có bài viết nào.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-8 flex justify-center">
            <nav class="flex items-center space-x-2">
                @if ($posts->onFirstPage())
                <span class="px-3 py-2 text-sm text-primary-400 cursor-not-allowed">← Trước</span>
                @else
                <a href="{{ $posts->previousPageUrl() }}"
                    class="px-3 py-2 text-sm text-primary-600 hover:text-primary-900">← Trước</a>
                @endif

                @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                @if ($page == $posts->currentPage())
                <span class="px-3 py-2 text-sm bg-primary-900 text-white rounded">{{ $page }}</span>
                @else
                <a href="{{ $url }}" class="px-3 py-2 text-sm text-primary-600 hover:text-primary-900">{{ $page }}</a>
                @endif
                @endforeach

                @if ($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}"
                    class="px-3 py-2 text-sm text-primary-600 hover:text-primary-900">Tiếp →</a>
                @else
                <span class="px-3 py-2 text-sm text-primary-400 cursor-not-allowed">Tiếp →</span>
                @endif
            </nav>
        </div>
        @endif
    </div>

    <!-- Clean Sidebar -->
    <div class="lg:col-span-1">
        <!-- Categories -->
        <div class="bg-white rounded-lg border border-primary-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-primary-900 mb-4">Chuyên mục</h3>
            <div class="space-y-2">
                @foreach($navigationCategories->take(6) as $category)
                <a href="{{ route('categories.show', $category) }}"
                    class="block text-primary-600 hover:text-primary-900 text-sm py-1">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>


    </div>
</div>

@endsection

@push('scripts')
<script>
function carousel() {
    return {
        currentSlide: 0,
        totalSlides: 5,

        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },

        prevSlide() {
            this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
        },

        init() {
            // Auto-play carousel every 5 seconds
            setInterval(() => {
                this.nextSlide();
            }, 5000);
        }
    }
}
</script>
@endpush