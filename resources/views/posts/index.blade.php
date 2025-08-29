@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-primary-900">Quản lý bài viết</h1>
    <a href="{{ route('posts.create') }}" class="btn-primary">Thêm bài viết mới</a>
</div>

<div class="bg-white rounded-lg border border-primary-200 shadow-sm">
    <div class="p-6">
        @if($posts->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-primary-200">
                    <thead class="bg-primary-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Tiêu đề</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Chuyên mục</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Tác giả</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Lượt xem</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Ngày tạo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-primary-500 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-primary-200">
                        @foreach($posts as $post)
                            <tr class="hover:bg-primary-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="text-primary-600 hover:text-primary-900 font-medium">
                                        {{ $post->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-700">{{ $post->category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-700">{{ $post->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($post->status === 'published')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Đã xuất bản</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Bản nháp</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-700">{{ $post->view_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-700">{{ $post->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('posts.edit', $post) }}" class="inline-flex items-center px-3 py-1.5 border border-primary-300 text-sm font-medium rounded-md text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Sửa
                                        </a>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" 
                                              onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center mt-6">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-primary-500 mb-4">Chưa có bài viết nào.</p>
                <a href="{{ route('posts.create') }}" class="btn-primary">Tạo bài viết đầu tiên</a>
            </div>
        @endif
    </div>
</div>
@endsection
