@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Admin Dashboard</h1>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_posts'] }}</h4>
                        <p class="mb-0">Tổng bài viết</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-file-text fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['published_posts'] }}</h4>
                        <p class="mb-0">Bài viết đã xuất bản</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['pending_comments'] }}</h4>
                        <p class="mb-0">Bình luận chờ duyệt</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-chat-dots fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $stats['total_users'] }}</h4>
                        <p class="mb-0">Tổng người dùng</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Bài viết gần đây -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Bài viết gần đây</h5>
            </div>
            <div class="card-body">
                @forelse($recentPosts as $post)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                {{ $post->user->name }} - {{ $post->created_at->format('d/m/Y') }}
                            </small>
                        </div>
                        <span class="badge {{ $post->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                            {{ $post->status === 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted">Chưa có bài viết nào.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bình luận chờ duyệt -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Bình luận chờ duyệt</h5>
            </div>
            <div class="card-body">
                @forelse($pendingComments as $comment)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $comment->user->name }}</strong>
                                <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <form method="POST" action="{{ route('comments.approve', $comment) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Duyệt</button>
                            </form>
                        </div>
                        <p class="mb-1">{{ $comment->content }}</p>
                        <small class="text-muted">
                            Trong bài: <a href="{{ route('posts.show', $comment->post->slug) }}">
                                {{ $comment->post->title }}
                            </a>
                        </small>
                    </div>
                @empty
                    <p class="text-muted">Không có bình luận nào chờ duyệt.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Thống kê chi tiết -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thống kê chi tiết</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <strong>Bài viết:</strong> {{ $stats['total_posts'] }} 
                        ({{ $stats['published_posts'] }} đã xuất bản, {{ $stats['draft_posts'] }} bản nháp)
                    </li>
                    <li class="mb-2">
                        <strong>Chuyên mục:</strong> {{ $stats['total_categories'] }} 
                        ({{ $stats['active_categories'] }} đang hoạt động)
                    </li>
                    <li class="mb-2">
                        <strong>Bình luận:</strong> {{ $stats['total_comments'] }} 
                        ({{ $stats['pending_comments'] }} chờ duyệt)
                    </li>
                    <li class="mb-2">
                        <strong>Người dùng:</strong> {{ $stats['total_users'] }} 
                        ({{ $stats['admin_users'] }} admin)
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Hành động nhanh</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tạo bài viết mới
                    </a>
                    <a href="{{ route('categories.create') }}" class="btn btn-success">
                        <i class="bi bi-folder-plus"></i> Tạo chuyên mục mới
                    </a>
                    <a href="{{ route('posts.index') }}" class="btn btn-info">
                        <i class="bi bi-list"></i> Quản lý bài viết
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-warning">
                        <i class="bi bi-gear"></i> Quản lý chuyên mục
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
