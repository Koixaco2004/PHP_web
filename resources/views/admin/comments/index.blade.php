@extends('layouts.app')

@section('title', 'Quản lý Bình luận')

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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-heading font-bold text-white">Quản lý Bình luận</h1>
                <p class="text-primary-100 dark:text-primary-200 mt-2">Giám sát và xóa bình luận spam hoặc vi phạm</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center text-white">
            <div class="text-right">
                <p class="text-sm text-primary-100 dark:text-primary-200">Tổng số bình luận</p>
                <p class="font-semibold text-lg text-primary-200 dark:text-primary-200">{{ $comments->total() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Comments Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700">
    <div class="px-6 py-4 border-b border-secondary-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-secondary-900 dark:text-primary-400-dark flex items-center">
                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Danh sách Bình luận
            </h2>
            <div class="flex items-center space-x-2">
                <span class="text-sm text-secondary-600 dark:text-gray-300">
                    Hiển thị {{ $comments->firstItem() ?? 0 }} - {{ $comments->lastItem() ?? 0 }} của {{ $comments->total() }} bình luận
                </span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-secondary-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider">
                        Nội dung
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider">
                        Người dùng
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider">
                        Bài viết
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider">
                        Ngày tạo
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider">
                        Hành động
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-secondary-200 dark:divide-gray-700">
                @forelse($comments as $comment)
                    <tr class="hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="max-w-md">
                                <p class="text-sm text-secondary-900 dark:text-primary-400-dark line-clamp-3">
                                    {{ Str::limit($comment->content, 150) }}
                                </p>
                                @if($comment->parent_id)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 mt-1">
                                        Phản hồi
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    @if($comment->user->avatar)
                                        @if(Str::startsWith($comment->user->avatar, ['http://', 'https://']))
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" onerror="this.src='{{ asset('hello.png') }}'">
                                        @else
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $comment->user->avatar) }}" alt="{{ $comment->user->name }}" onerror="this.src='{{ asset('hello.png') }}'">
                                        @endif
                                    @else
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('hello.png') }}" alt="{{ $comment->user->name }}">
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-secondary-900 dark:text-primary-400-dark">
                                        {{ $comment->user->name }}
                                    </div>
                                    <div class="text-sm text-secondary-500 dark:text-gray-300">
                                        {{ $comment->user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="max-w-xs">
                                <a href="{{ route('posts.show', $comment->post->slug) }}"
                                   class="text-sm font-medium text-primary-600 dark:text-primary-400-dark hover:text-primary-900 dark:hover:text-primary-300-dark transition-colors duration-200">
                                    {{ Str::limit($comment->post->title, 50) }}
                                </a>
                                <div class="text-xs text-secondary-500 dark:text-gray-300 mt-1">
                                    ID: {{ $comment->post->id }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500 dark:text-gray-300">
                            <div>{{ $comment->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs">{{ $comment->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('posts.show', $comment->post->slug) }}#comment-{{ $comment->id }}"
                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors duration-200"
                                   title="Xem bình luận">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors duration-200"
                                            title="Xóa bình luận"
                                            onclick="showConfirmationModal('Xác nhận xóa', 'Bạn có chắc chắn muốn xóa bình luận này?', 'Xóa', function() { this.closest('form').submit(); }); return false;">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 text-secondary-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-secondary-600 dark:text-gray-300 mb-2">Chưa có bình luận nào.</p>
                            <p class="text-sm text-secondary-500 dark:text-gray-400">Bình luận sẽ xuất hiện ở đây khi có người dùng tương tác.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($comments->hasPages())
        <div class="px-6 py-4 border-t border-secondary-200 dark:border-gray-700">
            {{ $comments->links() }}
        </div>
    @endif
</div>
@endsection