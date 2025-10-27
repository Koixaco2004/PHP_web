@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-900 rounded-xl shadow-lg p-8 mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 rounded-xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-heading font-bold text-white">Quản lý Bài viết</h1>
                <p class="text-primary-100 dark:text-primary-200 mt-2">Chỉnh sửa và quản lý tất cả bài viết</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center space-x-3">
            @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('admin.posts.pending') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold flex items-center transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Phê duyệt bài viết
                </a>
            @endif
            <a href="{{ route('posts.create') }}" class="bg-white text-primary-600 hover:bg-primary-50 px-6 py-3 rounded-lg font-semibold flex items-center transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm bài viết mới
            </a>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Tổng bài viết</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400-dark">{{ $totalPosts }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Đã xuất bản</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400-dark">{{ $publishedPosts }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Chờ phê duyệt</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400-dark">{{ $pendingPosts }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Tổng lượt xem</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400-dark">{{ $totalViews }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Posts Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700">
    <div class="px-6 py-4 border-b border-secondary-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-secondary-900 dark:text-primary-400-dark flex items-center">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Danh sách Bài viết
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-secondary-600 dark:text-gray-300">
                    Hiển thị {{ $posts->firstItem() ?? 0 }} - {{ $posts->lastItem() ?? 0 }} của {{ $posts->total() }} bài viết
                </span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        @if($posts->count() > 0)
            <table class="min-w-full table-fixed">
                <thead class="bg-secondary-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-[40%]">
                            Bài viết
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-[15%]">
                            Chuyên mục
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-[15%]">
                            Tác giả
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-[12%]">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-[10%]">
                            Ngày tạo
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-[8%]">
                            Hành động
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-secondary-200 dark:divide-gray-700">
                    @foreach($posts as $post)
                        <tr class="hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 w-[40%]">
                                <div class="flex flex-col space-y-3 overflow-hidden">
                                    <!-- Hình ảnh -->
                                    <div class="flex justify-start flex-shrink-0">
                                        @if($post->main_image)
                                            <img src="{{ $post->main_image }}" alt="{{ $post->title }}" class="h-24 w-32 rounded-lg object-cover shadow-sm">
                                        @else
                                            <div class="h-24 w-32 bg-secondary-100 dark:bg-gray-700 rounded-lg flex items-center justify-center shadow-sm">
                                                <svg class="w-8 h-8 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Title và Description -->
                                    <div class="space-y-1 overflow-hidden">
                                        <div class="text-sm font-medium text-secondary-900 dark:text-primary-400-dark">
                                            <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="hover:text-primary-600 dark:hover:text-primary-300 transition-colors duration-200 line-clamp-2 break-words overflow-hidden">
                                                {{ $post->title }}
                                            </a>
                                        </div>
                                        <div class="text-xs text-secondary-500 dark:text-gray-400 line-clamp-2 break-words overflow-hidden">
                                            {{ $post->excerpt ?? strip_tags(Str::limit($post->content, 100)) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-[15%]">
                                <div class="overflow-hidden">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 break-words">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-[15%]">
                                <div class="flex items-center overflow-hidden">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        @if($post->user->avatar)
                                            @if(Str::startsWith($post->user->avatar, ['http://', 'https://']))
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" onerror="this.src='{{ asset('hello.png') }}'">
                                            @else
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $post->user->avatar) }}" alt="{{ $post->user->name }}" onerror="this.src='{{ asset('hello.png') }}'">
                                            @endif
                                        @else
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('hello.png') }}" alt="{{ $post->user->name }}">
                                        @endif
                                    </div>
                                    <div class="ml-3 overflow-hidden">
                                        <div class="text-sm font-medium text-secondary-900 dark:text-primary-400-dark truncate">
                                            {{ $post->user->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-[12%]">
                                <div class="overflow-hidden">
                                    @if($post->approval_status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 whitespace-nowrap">
                                            ✓ Đã duyệt
                                        </span>
                                    @elseif($post->approval_status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 whitespace-nowrap">
                                            ⏳ Chờ duyệt
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 whitespace-nowrap">
                                            ✕ Từ chối
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 w-[10%]">
                                <div class="text-sm text-secondary-500 dark:text-gray-300 whitespace-nowrap">
                                    <div>{{ $post->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs">{{ $post->created_at->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-[8%]">
                                <div class="flex items-center justify-center space-x-2">
                                    @if($post->approval_status === 'pending')
                                        <!-- Chỉ hiển thị nút Xem cho bài pending -->
                                        <a href="{{ route('posts.edit', $post) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-primary-100 hover:bg-primary-200 dark:bg-primary-900 dark:hover:bg-primary-800 text-primary-700 dark:text-primary-300 rounded-lg transition-colors duration-200 text-xs font-medium"
                                           title="Xem & phê duyệt">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Xem
                                        </a>
                                    @else
                                        <!-- Hiển thị đầy đủ các nút cho bài đã duyệt hoặc từ chối -->
                                        <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors duration-200"
                                           title="Xem bài viết">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('posts.edit', $post) }}"
                                           class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300 transition-colors duration-200"
                                           title="Chỉnh sửa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors duration-200"
                                                    title="Xóa bài viết"
                                                    onclick="showConfirmationModal('Xác nhận xóa', 'Bạn có chắc chắn muốn xóa bài viết này?', 'Xóa', function() { document.getElementById('delete-form-{{ $post->id }}').submit(); }); return false;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-secondary-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-secondary-600 dark:text-gray-300 mb-2">Chưa có bài viết nào.</p>
                <p class="text-sm text-secondary-500 dark:text-gray-400 mb-4">Bắt đầu bằng cách tạo bài viết đầu tiên của bạn.</p>
                <a href="{{ route('posts.create') }}" class="btn-primary inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tạo bài viết đầu tiên
                </a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-secondary-200 dark:border-gray-700">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection