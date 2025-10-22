@extends('layouts.app')

@section('title', 'Hồ sơ của ' . $user->name)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
            <div class="relative">
                <!-- Cover Image -->
                <div class="h-48 bg-gradient-to-r from-green-600 via-green-500 to-emerald-500 dark:from-green-800 dark:via-green-700 dark:to-emerald-700 rounded-t-lg"></div>
                
                <!-- Profile Info -->
                <div class="px-6 pb-6">
                    <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-6">
                        <!-- Avatar -->
                        <div class="relative -mt-16 mb-4 sm:mb-0">
                            <div class="w-32 h-32 rounded-full border-2 border-green-500 dark:border-green-400 shadow-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('hello.png') }}" alt="Default Avatar"
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                        </div>
                        
                        <!-- User Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-primary-100-dark">{{ $user->name }}</h1>
                                    <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    @if($user->location)
                                        <p class="text-gray-500 dark:text-gray-400 flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $user->location }}
                                        </p>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                @auth
                                    @if(Auth::id() === $user->id)
                                        <div class="mt-4 sm:mt-0 flex space-x-3">
                                            <a href="{{ route('profile.edit') }}"
                                               class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-700 dark:hover:bg-green-400 transition duration-150">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                </svg>
                                                Chỉnh sửa hồ sơ
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-4 sm:mt-0">
                                            <button class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-700 dark:hover:bg-green-400 transition duration-150">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path>
                                                </svg>
                                                Theo dõi
                                            </button>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bio -->
                    @if($user->bio)
                        <div class="mt-6">
                            <p class="text-gray-700 dark:text-gray-300">{{ $user->bio }}</p>
                        </div>
                    @endif
                    
                    <!-- Additional Info -->
                    <div class="mt-6 flex flex-wrap gap-6 text-sm text-gray-500 dark:text-gray-400">
                        @if($user->website)
                            <a href="{{ $user->website }}" target="_blank" class="flex items-center hover:text-green-600 dark:hover:text-green-400">
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
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $user->profile_views }} lượt xem
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            Tham gia {{ $user->created_at->format('m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-primary-100-dark">{{ $user->posts->count() }}</p>
                        <p class="text-gray-500 dark:text-gray-400">Bài viết</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-primary-100-dark">{{ $totalComments }}</p>
                        <p class="text-gray-500 dark:text-gray-400">Bình luận</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-semibold text-gray-900 dark:text-primary-100-dark">{{ $user->role === 'admin' ? 'Admin' : 'User' }}</p>
                        <p class="text-gray-500 dark:text-gray-400">Vai trò</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User's Posts -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-900 dark:text-primary-100-dark">Bài viết của {{ $user->name }}</h2>
            </div>

            <div class="p-6">
                @if($posts->count() > 0)
                    <div class="space-y-4">
                        @foreach($posts as $post)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-green-400 mb-2">
                                            <a href="{{ route('posts.show', $post) }}" class="hover:text-green-600 dark:hover:text-green-400">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-300 mb-3">{{ Str::limit($post->content, 150) }}</p>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ $post->category->name }}</span>
                                            <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                            <span>{{ $post->comments->count() }} bình luận</span>
                                        </div>
                                    </div>
                                    @if($post->main_image)
                                        <div class="ml-4 flex-shrink-0">
                                            <img src="{{ $post->main_image }}" alt="" class="w-20 h-20 object-cover rounded-lg">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-primary-100-dark mb-2">Chưa có bài viết nào</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ $user->name }} chưa đăng bài viết nào.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
