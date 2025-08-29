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
                                <div class="post-status {{ $post->status == 'published' ? 'published' : 'draft' }}">
                                    <i class="bi bi-{{ $post->status == 'published' ? 'check-circle' : 'clock' }}"></i>
                                    {{ $post->status == 'published' ? 'Đã xuất bản' : 'Bản nháp' }}
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
                                        {{ strtoupper(substr($comment->user->name ?? 'Anonymous', 0, 1)) }}
                                    </div>
                                    <div class="comment-author-info">
                                        <h6>{{ $comment->user->name ?? 'Anonymous' }}</h6>
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
        </div>

        <div class="dashboard-sidebar">
            <!-- Quick Actions Widget -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="bi bi-lightning"></i>
                        Thao tác nhanh
                    </h3>
                </div>
                <div class="widget-body">
                    <div class="quick-actions-grid">
                        <a href="{{ route('posts.create') }}" class="quick-action-btn">
                            <i class="bi bi-plus-circle"></i>
                            Tạo bài viết
                        </a>
                        <a href="{{ route('categories.index') }}" class="quick-action-btn">
                            <i class="bi bi-tags"></i>
                            Quản lý danh mục
                        </a>
                        <a href="{{ route('users.index') }}" class="quick-action-btn">
                            <i class="bi bi-people"></i>
                            Quản lý người dùng
                        </a>
                        <a href="#" class="quick-action-btn">
                            <i class="bi bi-gear"></i>
                            Cài đặt
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Details Widget -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="bi bi-graph-up"></i>
                        Chi tiết thống kê
                    </h3>
                </div>
                <div class="widget-body">
                    <div class="stats-details-list">
                        <div class="stats-detail-item">
                            <div class="stats-detail-label">Bài viết hôm nay</div>
                            <div class="stats-detail-value">{{ $today_posts ?? 0 }}</div>
                        </div>
                        <div class="stats-detail-item">
                            <div class="stats-detail-label">Bài viết tuần này</div>
                            <div class="stats-detail-value">{{ $week_posts ?? 0 }}</div>
                        </div>
                        <div class="stats-detail-item">
                            <div class="stats-detail-label">Bình luận hôm nay</div>
                            <div class="stats-detail-value">{{ $today_comments ?? 0 }}</div>
                        </div>
                        <div class="stats-detail-item">
                            <div class="stats-detail-label">Lượt xem hôm nay</div>
                            <div class="stats-detail-value">{{ $today_views ?? 0 }}</div>
                        </div>
                        <div class="stats-detail-item">
                            <div class="stats-detail-label">Danh mục hoạt động</div>
                            <div class="stats-detail-value">{{ $active_categories ?? 0 }}</div>
                        </div>
                        <div class="stats-detail-item">
                            <div class="stats-detail-label">Người dùng hoạt động</div>
                            <div class="stats-detail-value">{{ $active_users ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Widget -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="bi bi-activity"></i>
                        Hoạt động gần đây
                    </h3>
                </div>
                <div class="widget-body">
                    <div class="empty-widget">
                        <div class="empty-widget-icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <h4 class="empty-widget-title">Tính năng sắp ra mắt</h4>
                        <p class="empty-widget-description">Theo dõi hoạt động người dùng trong thời gian thực.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Comment approval function
function approveComment(commentId) {
    if (confirm('Bạn có chắc chắn muốn duyệt bình luận này?')) {
        fetch(`/admin/comments/${commentId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra khi duyệt bình luận');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi duyệt bình luận');
        });
    }
}

// Comment deletion function
function deleteComment(commentId) {
    if (confirm('Bạn có chắc chắn muốn xóa bình luận này? Hành động này không thể hoàn tác.')) {
        fetch(`/admin/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra khi xóa bình luận');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa bình luận');
        });
    }
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to stats cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Set initial state for animation
    statCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });
});
</script>
@endpush
@endsection
