@extends('layouts.app')

@section('title', 'Trang chủ - Website Tin Tức')

@section('content')
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
                <article class="bg-white rounded-lg border border-primary-200 hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
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
                                    <span class="text-xs font-semibold text-white">{{ substr($post->user->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm text-primary-700">{{ $post->user->name }}</span>
                            </div>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-primary-600 hover:text-primary-900 text-sm font-medium">
                                Đọc tiếp →
                            </a>
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
                        <a href="{{ $posts->previousPageUrl() }}" class="px-3 py-2 text-sm text-primary-600 hover:text-primary-900">← Trước</a>
                    @endif

                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <span class="px-3 py-2 text-sm bg-primary-900 text-white rounded">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 text-sm text-primary-600 hover:text-primary-900">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}" class="px-3 py-2 text-sm text-primary-600 hover:text-primary-900">Tiếp →</a>
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
                @foreach($categories->take(6) as $category)
                    <a href="{{ route('categories.show', $category) }}" 
                       class="block text-primary-600 hover:text-primary-900 text-sm py-1">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Newsletter -->
        <div class="bg-primary-50 rounded-lg border border-primary-200 p-6">
            <h3 class="text-lg font-semibold text-primary-900 mb-3">Đăng ký nhận tin</h3>
            <p class="text-primary-600 text-sm mb-4">Nhận tin tức mới nhất qua email</p>
            <form class="space-y-3">
                <input type="email" placeholder="Email của bạn" 
                       class="w-full px-3 py-2 border border-primary-300 rounded text-sm focus:ring-2 focus:ring-primary-900 focus:border-primary-900">
                <button type="submit" class="w-full bg-primary-900 text-white py-2 rounded text-sm font-medium hover:bg-primary-800">
                    Đăng ký
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
