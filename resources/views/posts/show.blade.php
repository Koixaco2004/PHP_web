@extends('layouts.app')

@section('title', $post->title)

@section('content')
<!-- Draft Status Alert -->
@if($post->status === 'draft')
    <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4 mb-6 animate-fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                <p class="text-yellow-800 dark:text-yellow-200 font-medium">Bài viết ở trạng thái bản nháp</p>
                <p class="text-yellow-700 dark:text-yellow-300 text-sm">Chỉ bạn và quản trị viên có thể xem bài viết này. Công chúng chưa thể truy cập.</p>
            </div>
            @if(auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->role === 'admin'))
                <a href="{{ route('posts.edit', $post) }}" class="ml-auto btn-secondary text-sm">
                    Chỉnh sửa
                </a>
            @endif
        </div>
    </div>
@endif

<!-- Approval Status Alert for Published Posts -->
@if($post->status === 'published')
    @if($post->approval_status === 'pending')
        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4 mb-6 animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-yellow-800 dark:text-yellow-200 font-medium">Bài viết đang chờ phê duyệt</p>
                    <p class="text-yellow-700 dark:text-yellow-300 text-sm">Bài viết của bạn đang được quản trị viên xem xét. Sau khi được phê duyệt, bài viết sẽ hiển thị công khai.</p>
                </div>
                @if(auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->role === 'admin'))
                    <a href="{{ route('posts.edit', $post) }}" class="ml-auto btn-secondary text-sm">
                        Chỉnh sửa
                    </a>
                @endif
            </div>
        </div>
    @elseif($post->approval_status === 'rejected')
        <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg p-4 mb-6 animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 dark:text-red-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-red-800 dark:text-red-200 font-medium">Bài viết đã bị từ chối</p>
                    <p class="text-red-700 dark:text-red-300 text-sm">Bài viết của bạn chưa đạt yêu cầu để xuất bản. Vui lòng chỉnh sửa và gửi lại.</p>
                </div>
                @if(auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->role === 'admin'))
                    <a href="{{ route('posts.edit', $post) }}" class="ml-auto btn-secondary text-sm">
                        Chỉnh sửa
                    </a>
                @endif
            </div>
        </div>
    @elseif($post->approval_status === 'approved')
        <!-- Show approved badge for author/admin only -->
        @if(auth()->check() && (auth()->user()->id === $post->user_id || auth()->user()->role === 'admin'))
            <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4 mb-6 animate-fade-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-green-800 dark:text-green-200 font-medium">Bài viết đã được phê duyệt</p>
                        <p class="text-green-700 dark:text-green-300 text-sm">Bài viết đã được quản trị viên phê duyệt và đang hiển thị công khai.</p>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endif

<!-- Breadcrumb Navigation -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 dark:text-gray-400 mb-6 animate-fade-in">
    <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('categories.show', $post->category) }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">
        {{ $post->category->name }}
    </a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 dark:text-gray-300 font-medium truncate">{{ $post->title }}</span>
</nav>

<div class="grid grid-cols-1">
    <!-- Main Article Content -->
    <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Article Header -->
        <article class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 overflow-hidden mb-8 animate-slide-up">
            <!-- Category Badge -->
            <div class="p-6 pb-0">
                <div class="flex items-center justify-between mb-4">
                    <a href="{{ route('categories.show', $post->category) }}"
                       class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-primary-100 dark:bg-primary-900-dark text-primary-800 dark:text-primary-400-dark hover:bg-primary-200 dark:hover:bg-primary-800-dark transition-colors duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        {{ $post->category->name }}
                    </a>

                    <!-- Social Share Buttons -->
                    <div class="flex items-center space-x-2">
                        <button class="p-2 text-secondary-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400-dark hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg transition-all duration-200"
                                onclick="sharePost('facebook')" title="Chia sẻ Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </button>
                        <button class="p-2 text-secondary-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400-dark hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg transition-all duration-200"
                                onclick="sharePost('twitter')" title="Chia sẻ Twitter">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </button>
                        <button id="copyLinkBtn" class="p-2 text-secondary-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400-dark hover:bg-primary-50 dark:hover:bg-gray-700 rounded-lg transition-all duration-200"
                                onclick="copyLink()" title="Sao chép liên kết">
                            <svg id="copyIcon" class="w-5 h-5 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <svg id="checkIcon" class="w-5 h-5 hidden transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Article Title -->
                <h1 class="text-3xl md:text-4xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark mb-6 leading-tight">
                    {{ $post->title }}
                </h1>

                <!-- Article Meta -->
                <div class="flex items-center justify-between pb-6 border-b border-secondary-200 dark:border-gray-700">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center space-x-3">
                            @if($post->user->avatar)
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-primary-500">
                            @else
                                <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-primary-500">
                            @endif
                            <div>
                                <a href="{{ route('users.show', $post->user) }}" class="font-medium text-secondary-900 dark:text-primary-400-dark hover:text-primary-600 dark:hover:text-primary-300-dark">{{ $post->user->name }}</a>
                                <div class="text-sm text-secondary-500 dark:text-gray-400">Tác giả</div>
                            </div>
                        </div>

                        <div class="hidden md:flex items-center space-x-4 text-sm text-secondary-500 dark:text-gray-400">
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
                                {{ $post->comments->count() }} bình luận
                            </div>
                        </div>
                    </div>

                    <!-- Reading Time Estimate -->
                    <div class="text-sm text-secondary-500 dark:text-gray-400 bg-secondary-50 dark:bg-gray-700 px-3 py-1 rounded-full">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ ceil(str_word_count(strip_tags($post->content_html)) / 200) }} phút đọc
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
                    <div class="text-lg text-secondary-600 dark:text-gray-300 font-medium mb-8 p-4 bg-secondary-50 dark:bg-gray-700 rounded-lg border-l-4 border-primary-500 dark:border-primary-400-dark">
                        {!! $post->excerpt_html !!}
                    </div>
                @endif

                <!-- Post Images Gallery -->
                @if($post->images && $post->images->count() > 1)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark mb-4">Hình ảnh bài viết</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($post->images->sortBy('sort_order') as $image)
                                <div class="relative group cursor-pointer" onclick="openImageModal('{{ $image->image_url }}', '{{ $image->alt_text ?? $post->title }}')">
                                    <img src="{{ $image->image_url }}"
                                         alt="{{ $image->alt_text ?? $post->title }}"
                                         class="w-full h-32 object-cover rounded-lg shadow-sm group-hover:shadow-md transition-shadow duration-200">
                                    @if($image->is_featured)
                                        <div class="absolute top-2 left-2">
                                            <span class="bg-primary-600 dark:bg-primary-100-dark text-white dark:text-primary-900-dark text-xs px-2 py-1 rounded-full">Ảnh đại diện</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 dark:group-hover:bg-opacity-30 transition-all duration-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="prose prose-lg max-w-none prose-headings:font-heading prose-headings:text-secondary-900 dark:prose-headings:text-primary-100-dark prose-p:text-secondary-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed prose-a:text-primary-600 dark:prose-a:text-primary-400-dark prose-a:no-underline hover:prose-a:text-primary-700 dark:hover:prose-a:text-primary-300-dark prose-strong:text-secondary-900 dark:prose-strong:text-primary-100-dark prose-blockquote:border-primary-500 dark:prose-blockquote:border-primary-400-dark prose-blockquote:bg-primary-50 dark:prose-blockquote:bg-gray-700 prose-blockquote:rounded-r-lg">
                    {!! $post->content_html !!}
                </div>

                <!-- Article Footer -->
                <div class="mt-8 pt-6 border-t border-secondary-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-secondary-500 dark:text-gray-400">
                            Bài viết được đăng lúc {{ $post->created_at->format('H:i, d/m/Y') }}
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-secondary-500 dark:text-gray-400">Chia sẻ:</span>
                            <button onclick="sharePost('facebook')" class="p-1.5 text-secondary-400 dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </button>
                            <button onclick="sharePost('twitter')" class="p-1.5 text-secondary-400 dark:text-gray-500 hover:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 overflow-hidden animate-slide-up" style="animation-delay: 0.1s">
            <div class="p-6 border-b border-secondary-200 dark:border-gray-700 bg-secondary-50 dark:bg-gray-700">
                <h3 class="text-xl font-heading font-semibold text-secondary-900 dark:text-primary-400-dark flex items-center">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Bình luận ({{ $post->comments->count() }})
                </h3>
            </div>

            <div class="p-6">
                @auth
                    <!-- Comment Form for Logged-in Users -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-primary-50 dark:from-gray-700 to-primary-100 dark:to-gray-600 rounded-xl">
                        <h4 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark mb-4">Để lại bình luận của bạn</h4>
                        <form method="POST" action="{{ route('comments.store', $post) }}" class="space-y-4">
                            @csrf
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <textarea name="content" rows="3" class="w-full px-4 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400" placeholder="Viết bình luận của bạn..." required></textarea>
                                    <input type="hidden" name="parent_id" id="parent_id" value="">
                                    <div class="mt-3 flex justify-end">
                                        <button type="submit" class="px-4 py-2 bg-primary-600 dark:bg-primary-100-dark text-white dark:text-primary-900-dark rounded-lg hover:bg-primary-700 dark:hover:bg-primary-200-dark transition-colors duration-200">
                                            Gửi bình luận
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Login Prompt for Guests -->
                    <div class="mb-8 p-6 bg-secondary-50 dark:bg-gray-700 rounded-xl text-center">
                        <div class="flex flex-col items-center justify-center space-y-2">
                            <svg class="w-12 h-12 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="text-secondary-700 dark:text-gray-300 font-medium">Bạn cần đăng nhập để bình luận</p>
                            <p class="text-secondary-500 dark:text-gray-400 text-sm">
                                <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium">Đăng nhập</a>
                                hoặc
                                <a href="{{ route('register') }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium">tạo tài khoản</a>
                                để tham gia thảo luận
                            </p>
                        </div>
                    </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-6">
                    @forelse($post->comments as $comment)
                        <div class="comment-item animate-slide-up" style="--animation-delay: {{ $loop->index * 0.1 }}s; animation-delay: var(--animation-delay);">
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-lg">{{ substr($comment->user->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1 bg-secondary-50 dark:bg-gray-700 rounded-xl p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="font-semibold text-secondary-900 dark:text-primary-400-dark">{{ $comment->user->name }}</h5>
                                        <time class="text-sm text-secondary-500 dark:text-gray-400">{{ $comment->created_at->format('d/m/Y H:i') }}</time>
                                    </div>
                                    <p class="text-secondary-700 dark:text-gray-300 mb-3">{{ $comment->content }}</p>


                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-secondary-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h4 class="text-lg font-medium text-secondary-900 dark:text-primary-400-dark mb-2">Chưa có bình luận nào</h4>
                            <p class="text-secondary-500 dark:text-gray-400">Hãy là người đầu tiên bình luận về bài viết này!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Posts Section -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h3 class="text-2xl font-bold text-primary-900 dark:text-primary-400-dark mb-6">Tin tức liên quan</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $relatedPosts = \App\Models\Post::where('category_id', $post->category_id)
                ->where('id', '!=', $post->id)
                ->where('status', 'published')
                ->latest()
                ->take(3)
                ->get();
        @endphp
        
        @forelse($relatedPosts as $relatedPost)
            <article class="bg-white dark:bg-gray-800 rounded-lg border border-primary-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-gray-900/20 transition-all duration-200 overflow-hidden">
                @if($relatedPost->main_image)
                    <div class="h-48 overflow-hidden">
                        <img src="{{ $relatedPost->main_image }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                @endif
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-primary-600 dark:text-primary-400-dark bg-primary-50 dark:bg-primary-900-dark px-2 py-1 rounded">
                            {{ $relatedPost->category->name }}
                        </span>
                        <span class="text-xs text-primary-500 dark:text-gray-400">{{ $relatedPost->created_at->diffForHumans() }}</span>
                    </div>

                    <h4 class="text-lg font-semibold text-primary-900 dark:text-primary-400-dark mb-2 leading-tight">
                        <a href="{{ route('posts.show', $relatedPost->slug) }}" class="hover:text-primary-700 dark:hover:text-primary-300-dark">
                            {{ Str::limit($relatedPost->title, 60) }}
                        </a>
                    </h4>

                    @if($relatedPost->excerpt)
                        <p class="text-primary-600 dark:text-gray-300 mb-3 line-clamp-2 text-sm leading-relaxed">{{ Str::limit(strip_tags($relatedPost->excerpt_html), 100) }}</p>
                    @endif

                    <div class="flex items-center justify-between pt-2 border-t border-primary-100 dark:border-gray-700">
                        <div class="flex items-center space-x-2">
                            <div class="w-5 h-5 bg-primary-900 dark:bg-primary-100-dark rounded-full flex items-center justify-center">
                                <span class="text-xs font-semibold text-white dark:text-primary-900-dark">{{ substr($relatedPost->user->name, 0, 1) }}</span>
                            </div>
                            <span class="text-xs text-primary-700 dark:text-gray-300">{{ $relatedPost->user->name }}</span>
                        </div>
                        <a href="{{ route('posts.show', $relatedPost->slug) }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark text-xs font-medium">
                            Đọc tiếp →
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-8">
                <p class="text-primary-500 dark:text-gray-400">Không có tin tức liên quan.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Reply Modal -->
@auth


<script>
document.addEventListener('DOMContentLoaded', function() {
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

    window.copyLink = function() {
        const copyIcon = document.getElementById('copyIcon');
        const checkIcon = document.getElementById('checkIcon');
        const copyBtn = document.getElementById('copyLinkBtn');
        
        navigator.clipboard.writeText(window.location.href).then(function() {
            copyIcon.classList.add('hidden');
            checkIcon.classList.remove('hidden');
            
            copyBtn.classList.remove('text-secondary-500', 'dark:text-gray-400');
            copyBtn.classList.add('text-primary-600', 'dark:text-primary-400');
            
            checkIcon.style.transform = 'scale(1.2)';
            setTimeout(() => {
                checkIcon.style.transform = 'scale(1)';
            }, 200);
            
            setTimeout(() => {
                checkIcon.classList.add('hidden');
                copyIcon.classList.remove('hidden');
                copyBtn.classList.remove('text-primary-600', 'dark:text-primary-400');
                copyBtn.classList.add('text-secondary-500', 'dark:text-gray-400');
            }, 2000);
        }).catch(function(err) {
            console.error('Failed to copy link:', err);
            alert('Không thể sao chép liên kết!');
        });
    };

    window.openImageModal = function(imageUrl, altText) {
        let modal = document.getElementById('imageModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'imageModal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-75 dark:bg-black dark:bg-opacity-90 z-50 flex items-center justify-center p-4';
            modal.innerHTML = `
                <div class="relative max-w-4xl max-h-full">
                    <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
                    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white dark:text-gray-300 hover:text-gray-300 dark:hover:text-white transition-colors duration-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            document.body.appendChild(modal);
            
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeImageModal();
                }
            });
        }
        
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
