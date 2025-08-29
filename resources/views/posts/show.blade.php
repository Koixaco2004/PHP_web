@extends('layouts.app')

@section('title', $post->title)

@section('content')
<!-- Breadcrumb Navigation -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 mb-6 animate-fade-in">
    <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('categories.show', $post->category) }}" class="hover:text-primary-600 transition-colors duration-200">
        {{ $post->category->name }}
    </a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 font-medium truncate">{{ $post->title }}</span>
</nav>

<div class="grid grid-cols-1">
    <!-- Main Article Content -->
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Article Header -->
        <article class="bg-white rounded-xl shadow-sm border border-secondary-200 overflow-hidden mb-8 animate-slide-up">
            <!-- Category Badge -->
            <div class="p-6 pb-0">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('categories.show', $post->category) }}" 
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-primary-100 text-primary-800 hover:bg-primary-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        {{ $post->category->name }}
                    </a>
                    
                    <!-- Social Share Buttons -->
                    <div class="flex items-center space-x-2">
                        <button class="p-2 text-secondary-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all duration-200" 
                                onclick="sharePost('facebook')" title="Chia sẻ Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </button>
                        <button class="p-2 text-secondary-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all duration-200" 
                                onclick="sharePost('twitter')" title="Chia sẻ Twitter">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </button>
                        <button class="p-2 text-secondary-500 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all duration-200" 
                                onclick="copyLink()" title="Sao chép liên kết">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Article Title -->
                <h1 class="text-3xl md:text-4xl font-heading font-bold text-secondary-900 mb-6 leading-tight">
                    {{ $post->title }}
                </h1>

                <!-- Article Meta -->
                <div class="flex items-center justify-between pb-6 border-b border-secondary-200">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold">{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <div class="font-medium text-secondary-900">{{ $post->user->name }}</div>
                                <div class="text-sm text-secondary-500">Tác giả</div>
                            </div>
                        </div>
                        
                        <div class="hidden md:flex items-center space-x-4 text-sm text-secondary-500">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $post->created_at->format('d/m/Y H:i') }}
                            </div>
                            <span>•</span>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ $post->view_count }} lượt xem
                            </div>
                            <span>•</span>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                {{ $post->comments->where('is_approved', true)->count() }} bình luận
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reading Time Estimate -->
                    <div class="text-sm text-secondary-500 bg-secondary-50 px-3 py-1 rounded-full">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} phút đọc
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if($post->main_image)
                <div class="mb-6">
                    <img src="{{ $post->main_image }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-64 md:h-80 object-cover rounded-lg shadow-sm">
                </div>
            @endif

            <!-- Article Content -->
            <div class="p-6">
                @if($post->excerpt)
                    <div class="text-lg text-secondary-600 font-medium mb-8 p-4 bg-secondary-50 rounded-lg border-l-4 border-primary-500">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <!-- Post Images Gallery -->
                @if($post->images && $post->images->count() > 1)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-secondary-900 mb-4">Hình ảnh bài viết</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($post->images->sortBy('sort_order') as $image)
                                <div class="relative group cursor-pointer" onclick="openImageModal('{{ $image->image_url }}', '{{ $image->alt_text ?? $post->title }}')">
                                    <img src="{{ $image->image_url }}" 
                                         alt="{{ $image->alt_text ?? $post->title }}" 
                                         class="w-full h-32 object-cover rounded-lg shadow-sm group-hover:shadow-md transition-shadow duration-200">
                                    @if($image->is_featured)
                                        <div class="absolute top-2 left-2">
                                            <span class="bg-primary-600 text-white text-xs px-2 py-1 rounded-full">Ảnh đại diện</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="prose prose-lg max-w-none prose-headings:font-heading prose-headings:text-secondary-900 prose-p:text-secondary-700 prose-p:leading-relaxed prose-a:text-primary-600 prose-a:no-underline hover:prose-a:text-primary-700 prose-strong:text-secondary-900 prose-blockquote:border-primary-500 prose-blockquote:bg-primary-50 prose-blockquote:rounded-r-lg">
                    {!! $post->content !!}
                </div>

                <!-- Article Footer -->
                <div class="mt-8 pt-6 border-t border-secondary-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-secondary-500">
                            Bài viết được đăng lúc {{ $post->created_at->format('H:i, d/m/Y') }}
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-secondary-500">Chia sẻ:</span>
                            <button onclick="sharePost('facebook')" class="p-1.5 text-secondary-400 hover:text-blue-600 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </button>
                            <button onclick="sharePost('twitter')" class="p-1.5 text-secondary-400 hover:text-blue-400 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="bg-white rounded-xl shadow-sm border border-secondary-200 overflow-hidden animate-slide-up" style="animation-delay: 0.1s">
            <div class="p-6 border-b border-secondary-200 bg-secondary-50">
                <h3 class="text-xl font-heading font-semibold text-secondary-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Bình luận ({{ $post->comments->count() }})
                </h3>
            </div>
            
            <div class="p-6">
                @auth
                    <!-- Comment Form for Logged-in Users -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-primary-50 to-primary-100 rounded-xl">
                        <h4 class="text-lg font-semibold text-secondary-900 mb-4">Để lại bình luận của bạn</h4>
                        <form method="POST" action="{{ route('comments.store', $post) }}" class="space-y-4">
                            @csrf
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <textarea name="content" rows="3" class="w-full px-4 py-2 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Viết bình luận của bạn..." required></textarea>
                                    <input type="hidden" name="parent_id" id="parent_id" value="">
                                    <div class="mt-3 flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                            Gửi bình luận
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Login Prompt for Guests -->
                    <div class="mb-8 p-6 bg-secondary-50 rounded-xl text-center">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <svg class="w-12 h-12 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="text-secondary-700 font-medium">Bạn cần đăng nhập để bình luận</p>
                            <p class="text-secondary-500 text-sm">
                                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">Đăng nhập</a> 
                                hoặc 
                                <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-medium">tạo tài khoản</a> 
                                để tham gia thảo luận
                            </p>
                        </div>
                    </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-6">
                    @forelse($post->comments->whereNull('parent_id') as $comment)
                        <div class="comment-item animate-slide-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-lg">{{ substr($comment->user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1 bg-secondary-50 rounded-xl p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="font-semibold text-secondary-900">{{ $comment->user->name }}</h5>
                                        <time class="text-sm text-secondary-500">{{ $comment->created_at->format('d/m/Y H:i') }}</time>
                                    </div>
                                    <p class="text-secondary-700 mb-3">{{ $comment->content }}</p>
                                    
                                    @auth
                                        <button class="reply-btn text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center transition-colors duration-200" 
                                                data-comment-id="{{ $comment->id }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                            </svg>
                                            Trả lời
                                        </button>
                                    @endauth

                                    <!-- Replies -->
                                    @if($comment->children->where('is_approved', true)->count() > 0)
                                        <div class="mt-4 space-y-3">
                                            @foreach($comment->children->where('is_approved', true) as $reply)
                                                <div class="flex space-x-3 ml-4">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-8 h-8 bg-gradient-to-br from-secondary-500 to-secondary-600 rounded-full flex items-center justify-center">
                                                            <span class="text-white font-medium text-sm">{{ substr($reply->user->name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 bg-white rounded-lg p-3 shadow-sm">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <h6 class="font-medium text-secondary-900 text-sm">{{ $reply->user->name }}</h6>
                                                            <time class="text-xs text-secondary-500">{{ $reply->created_at->format('d/m/Y H:i') }}</time>
                                                        </div>
                                                        <p class="text-secondary-700 text-sm">{{ $reply->content }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-secondary-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h4 class="text-lg font-medium text-secondary-900 mb-2">Chưa có bình luận nào</h4>
                            <p class="text-secondary-500">Hãy là người đầu tiên bình luận về bài viết này!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Posts Section -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h3 class="text-2xl font-bold text-primary-900 mb-6">Tin tức liên quan</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $relatedPosts = \App\Models\Post::where('category_id', $post->category_id)
                ->where('id', '!=', $post->id)
                ->where('status', 'published')
                ->latest()
                ->take(3)
                ->get();
        @endphp
        
        @forelse($relatedPosts as $relatedPost)
            <article class="bg-white rounded-lg border border-primary-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                @if($relatedPost->featured_image)
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $relatedPost->featured_image }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                @endif
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                            {{ $relatedPost->category->name }}
                        </span>
                        <span class="text-xs text-primary-500">{{ $relatedPost->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <h4 class="text-lg font-semibold text-primary-900 mb-2 leading-tight">
                        <a href="{{ route('posts.show', $relatedPost->slug) }}" class="hover:text-primary-700">
                            {{ Str::limit($relatedPost->title, 60) }}
                        </a>
                    </h4>
                    
                    @if($relatedPost->excerpt)
                        <p class="text-primary-600 mb-3 line-clamp-2 text-sm leading-relaxed">{{ Str::limit($relatedPost->excerpt, 100) }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between pt-2 border-t border-primary-100">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-primary-900 rounded-full flex items-center justify-center">
                                <span class="text-xs font-semibold text-white">{{ substr($relatedPost->user->name, 0, 1) }}</span>
                            </div>
                            <span class="text-xs text-primary-700">{{ $relatedPost->user->name }}</span>
                        </div>
                        <a href="{{ route('posts.show', $relatedPost->slug) }}" class="text-primary-600 hover:text-primary-900 text-xs font-medium">
                            Đọc tiếp →
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-primary-500">Không có tin tức liên quan.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Reply Modal -->
@auth
<div id="replyModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full animate-slide-up">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-semibold text-secondary-900">Trả lời bình luận</h3>
                <button type="button" class="close-modal text-secondary-400 hover:text-secondary-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="POST" action="{{ route('comments.store', $post) }}" class="space-y-4">
                @csrf
                <input type="hidden" name="parent_id" id="parent_id">
                <div>
                    <label for="reply_content" class="block text-sm font-medium text-secondary-700 mb-2">Nội dung trả lời</label>
                    <textarea class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 resize-none" 
                              id="reply_content" name="content" rows="4" placeholder="Nhập phản hồi của bạn..." required></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="button" class="close-modal btn-secondary flex-1">Hủy</button>
                    <button type="submit" class="btn-primary flex-1">Gửi trả lời</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reply Modal functionality
    const replyButtons = document.querySelectorAll('.reply-btn');
    const replyModal = document.getElementById('replyModal');
    const closeModalButtons = document.querySelectorAll('.close-modal');
    const parentIdInput = document.getElementById('parent_id');
    const replyContent = document.getElementById('reply_content');

    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            parentIdInput.value = commentId;
            replyContent.value = '';
            replyModal.classList.remove('hidden');
        });
    });

    closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            replyModal.classList.add('hidden');
        });
    });

    // Close modal when clicking outside
    replyModal.addEventListener('click', function(e) {
        if (e.target === replyModal) {
            replyModal.classList.add('hidden');
        }
    });

    // Social sharing functions
    window.sharePost = function(platform) {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent(document.title);
        
        let shareUrl = '';
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                break;
        }
        
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    };

    // Copy link function
    window.copyLink = function() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            // Show success message (you can implement a toast notification here)
            alert('Đã sao chép liên kết!');
        });
    };

    // Image modal functionality
    window.openImageModal = function(imageUrl, altText) {
        // Create modal if it doesn't exist
        let modal = document.getElementById('imageModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'imageModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="relative max-w-4xl max-h-full">
                    <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
                    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors duration-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            document.body.appendChild(modal);
            
            // Close on click outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeImageModal();
                }
            });
        }
        
        // Update image and show modal
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modalImage.alt = altText;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeImageModal = function() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    };

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
@endauth
@endsection
