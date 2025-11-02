@extends('layouts.app')

@section('title', 'Hồ sơ của tôi')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6 sm:mb-8">
            <div class="relative">
                <!-- Cover Image -->
                <div class="h-32 sm:h-48 bg-gradient-to-r from-primary-600 via-primary-500 to-primary-400 dark:from-primary-800-dark dark:via-primary-700-dark dark:to-primary-600-dark rounded-t-lg"></div>
                
                <!-- Profile Info -->
                <div class="px-4 sm:px-6 pb-4 sm:pb-6">
                    <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-6">
                        <!-- Avatar -->
                        <div class="relative -mt-12 sm:-mt-16 mb-3 sm:mb-0">
                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-2 sm:border-4 border-primary-500 dark:border-primary-400-dark shadow-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                @if($user->avatar)
                                    @if(Str::startsWith($user->avatar, ['http://', 'https://']))
                                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                                             class="w-full h-full object-cover" onerror="this.src='{{ asset('hello.png') }}'">
                                    @else
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                             class="w-full h-full object-cover" onerror="this.src='{{ asset('hello.png') }}'">
                                    @endif
                                @else
                                    <img src="{{ asset('hello.png') }}" alt="Default Avatar"
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                        </div>
                        
                        <!-- User Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                                <div class="min-w-0">
                                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-primary-400-dark truncate">{{ $user->name }}</h1>
                                    <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                    @if($user->location)
                                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 flex items-center mt-1">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $user->location }}
                                        </p>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex space-x-2 sm:space-x-3">
                                    <a href="{{ route('profile.edit') }}"
                                       class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-primary-600 dark:bg-primary-500-dark text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-primary-700 dark:hover:bg-primary-400-dark transition duration-150">
                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                        Chỉnh sửa hồ sơ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bio -->
                    @if($user->bio)
                        <div class="mt-4 sm:mt-6">
                            <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300">{{ $user->bio }}</p>
                        </div>
                    @endif
                    
                    <!-- Additional Info -->
                    <div class="mt-4 sm:mt-6 flex flex-wrap gap-4 sm:gap-6 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                        @if($user->website)
                            <a href="{{ $user->website }}" target="_blank" class="flex items-center hover:text-primary-600 dark:hover:text-primary-400-dark">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path>
                                </svg>
                                Website
                            </a>
                        @endif
                        @if($user->date_of_birth)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($user->date_of_birth)->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-primary-100 dark:bg-primary-900-dark rounded-full">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <p class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-primary-400-dark">{{ $user->posts->count() }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Bài viết</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-primary-100 dark:bg-primary-900-dark rounded-full">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <p class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-primary-400-dark">{{ $totalComments }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Bình luận</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 sm:p-3 bg-primary-100 dark:bg-primary-900-dark rounded-full">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <p class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-primary-400-dark">{{ $user->profile_views }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Lượt xem</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="-mb-px flex space-x-4 sm:space-x-8 px-4 sm:px-6 overflow-x-auto" aria-label="Tabs">
                    <div class="border-primary-500 text-primary-600 dark:text-primary-400-dark dark:border-primary-400-dark whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-sm">
                        Bài viết gần đây
                    </div>
                </nav>
            </div>

            <!-- Recent Posts -->
            <div id="posts" class="p-4 sm:p-6">
                @if($posts->count() > 0)
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">3 bài viết gần đây</h3>
                        <a href="{{ route('profile.posts') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium text-xs sm:text-sm flex items-center">
                            Xem tất cả
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-3 sm:space-y-4">
                        @foreach($posts as $post)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 sm:p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <div class="flex justify-between items-start gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center flex-wrap gap-2 mb-2">
                                            <span class="px-2 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold rounded-full bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
                                                {{ $post->category->name }}
                                            </span>
                                            @php
                                                $approvalClasses = match($post->approval_status) {
                                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                    default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                };
                                                $approvalText = match($post->approval_status) {
                                                    'approved' => 'Đã duyệt',
                                                    'pending' => 'Chờ duyệt',
                                                    default => 'Từ chối',
                                                };
                                            @endphp
                                            <span class="px-2 py-0.5 sm:py-1 text-[10px] sm:text-xs font-semibold rounded-full {{ $approvalClasses }}">
                                                {{ $approvalText }}
                                            </span>
                                        </div>
                                        <h3 class="text-sm sm:text-base md:text-lg font-medium text-gray-900 dark:text-primary-400-dark mb-2 line-clamp-2">
                                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-primary-600 dark:hover:text-primary-400">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mb-2 sm:mb-3 line-clamp-2">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                                        <div class="flex items-center flex-wrap gap-2 sm:gap-4 text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">
                                            <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ $post->view_count }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                {{ $post->comment_count }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <img src="{{ $post->main_image }}" alt="" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-lg">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-8 sm:py-12">
                        <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-gray-400 dark:text-gray-500 mb-3 sm:mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-primary-400-dark mb-2">Chưa có bài viết nào</h3>
                        <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mb-4">Hãy bắt đầu chia sẻ những câu chuyện của bạn!</p>
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-primary-600 dark:bg-primary-500-dark text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-primary-700 dark:hover:bg-primary-400-dark">
                            Tạo bài viết đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabLinks = document.querySelectorAll('.tab-link');
    
    tabLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                
                tabLinks.forEach(tab => {
                    tab.classList.remove('border-primary-500', 'text-primary-600', 'dark:text-primary-400-dark', 'dark:border-primary-400-dark');
                    tab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                });

                this.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                this.classList.add('border-primary-500', 'text-primary-600', 'dark:text-primary-400-dark', 'dark:border-primary-400-dark');
            }
        });
    });
});
</script>
@endsection
