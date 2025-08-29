@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
       </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <div class="dashboard-main">
            <!-- Recent Posts Widget -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="bi bi-clock-history"></i>
                        Bài viết gần đây
                    </h3>
                    <a href="{{ route('posts.index') }}" class="widget-action">
                        Xem tất cả <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="widget-body">
                    @if($recent_posts->count() > 0)
                    <div class="recent-posts-list">
                        @foreach($recent_posts as $post)
                        <div class="recent-post-item">
                            <div class="post-thumbnail">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="post-details">
                                <h5 class="post-title">
                                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                </h5>
                                <div class="post-meta">
                                    <span><i class="bi bi-person"></i> {{ $post->user->name }}</span>
                                    <span><i class="bi bi-calendar"></i> {{ $post->created_at->format('d/m/Y') }}</span>
                                    <span><i class="bi bi-eye"></i> {{ $post->views ?? 0 }} lượt xem</span>
                                </div>
                                <div class="post-status {{ $post->is_published ? 'published' : 'draft' }}">
                                    <i class="bi bi-{{ $post->is_published ? 'check-circle' : 'clock' }}"></i>
                                    {{ $post->is_published ? 'Đã xuất bản' : 'Bản nháp' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-widget">
                        <div class="empty-widget-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h4 class="empty-widget-title">Chưa có bài viết nào</h4>
                        <p class="empty-widget-description">Hãy tạo bài viết đầu tiên để bắt đầu!</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pending Comments Widget -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="bi bi-chat-dots"></i>
                        Bình luận chờ duyệt
                    </h3>
                    <a href="#" class="widget-action">
                        Xem tất cả <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="widget-body">
                    @if($comments_pending->count() > 0)
                    <div class="pending-comments-list">
                        @foreach($comments_pending as $comment)
                        <div class="comment-item">
                            <div class="comment-header">
                                <div class="comment-author">
                                    <div class="comment-avatar">
                                        {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                                    </div>
                                    <div class="comment-author-info">
                                        <h6>{{ $comment->author_name }}</h6>
                                        <div class="comment-date">
                                            <i class="bi bi-clock"></i>
                                            {{ $comment->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-actions">
                                    <button class="btn btn-outline-success btn-sm" onclick="approveComment({{ $comment->id }})">
                                        <i class="bi bi-check"></i> Duyệt
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteComment({{ $comment->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="comment-content">
                                {{ Str::limit($comment->content, 150) }}
                            </div>
                            <div class="comment-post-link">
                                <i class="bi bi-file-earmark-text"></i>
                                Bài viết: <a href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-widget">
                        <div class="empty-widget-icon">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <h4 class="empty-widget-title">Không có bình luận nào chờ duyệt</h4>
                        <p class="empty-widget-description">Tuyệt vời! Bạn đã xử lý hết tất cả bình luận.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>-12">
        <h1 class="mb-4">Admin Dashboard</h1>
    </div>
</div>

<!-- Thống kê tổng quan -->
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/admin-dashboard.css') }}">
@endpush

@section('content')
<div class="admin-dashboard">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="dashboard-header-content">
            <div>
                <h1 class="dashboard-title">Dashboard Quản Trị</h1>
                <p class="dashboard-subtitle">Chào mừng trở lại! Dưới đây là tổng quan về website của bạn.</p>
            </div>
            <div class="dashboard-user-info">
                <div class="dashboard-user-name">{{ Auth::user()->name }}</div>
                <div class="dashboard-user-role">
                    <i class="bi bi-shield-check"></i>
                    {{ Auth::user()->role == 'admin' ? 'Quản trị viên' : 'Biên tập viên' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-content">
                <div class="stat-details">
                    <h3>{{ $total_posts }}</h3>
                    <p>Tổng bài viết</p>
                    <div class="stat-trend up">
                        <i class="bi bi-arrow-up"></i>
                        +12% so với tháng trước
                    </div>
                </div>
                <div class="stat-icon primary">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card success">
            <div class="stat-content">
                <div class="stat-details">
                    <h3>{{ $published_posts }}</h3>
                    <p>Đã xuất bản</p>
                    <div class="stat-trend up">
                        <i class="bi bi-arrow-up"></i>
                        +8% so với tháng trước
                    </div>
                </div>
                <div class="stat-icon success">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card warning">
            <div class="stat-content">
                <div class="stat-details">
                    <h3>{{ $pending_comments }}</h3>
                    <p>Bình luận chờ duyệt</p>
                    <div class="stat-trend neutral">
                        <i class="bi bi-dash"></i>
                        Không thay đổi
                    </div>
                </div>
                <div class="stat-icon warning">
                    <i class="bi bi-chat-dots"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card info">
            <div class="stat-content">
                <div class="stat-details">
                    <h3>{{ $total_users }}</h3>
                    <p>Người dùng</p>
                    <div class="stat-trend up">
                        <i class="bi bi-arrow-up"></i>
                        +25% so với tháng trước
                    </div>
                </div>
                <div class="stat-icon info">
                    <i class="bi bi-people"></i>
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
