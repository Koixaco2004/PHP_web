@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quản lý bài viết</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">Thêm bài viết mới</a>
</div>

<div class="card">
    <div class="card-body">
        @if($posts->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Chuyên mục</th>
                            <th>Tác giả</th>
                            <th>Trạng thái</th>
                            <th>Lượt xem</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank">
                                        {{ $post->title }}
                                    </a>
                                </td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>
                                    @if($post->status === 'published')
                                        <span class="badge bg-success">Đã xuất bản</span>
                                    @else
                                        <span class="badge bg-warning">Bản nháp</span>
                                    @endif
                                </td>
                                <td>{{ $post->view_count }}</td>
                                <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">
                                            Sửa
                                        </a>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" 
                                              onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')" 
                                              style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">Chưa có bài viết nào.</p>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Tạo bài viết đầu tiên</a>
            </div>
        @endif
    </div>
</div>
@endsection
