@extends('layouts.app')

@section('title', 'Trang chủ - Website Tin Tức')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <h1 class="page-title">
            <i class="bi bi-newspaper"></i>
            Tin Tức Mới Nhất
        </h1>
        <p class="page-subtitle">Cập nhật thông tin nhanh chóng và chính xác từ mọi miền đất nước</p>
    </div>
</div>

<!-- Search Section -->
<div class="search-section">
    <form method="GET" action="{{ route('home') }}" class="search-form">
        <div class="form-group">
            <label for="search" class="form-label">
                <i class="bi bi-search"></i> Tìm kiếm bài viết
            </label>
            <input type="text" 
                   id="search"
                   name="search" 
                   class="form-control" 
                   placeholder="Nhập từ khóa tìm kiếm..." 
                   value="{{ request('search') }}">
        </div>
        
        <div class="form-group">
            <label for="category" class="form-label">
                <i class="bi bi-folder"></i> Chuyên mục
            </label>
            <select name="category" id="category" class="form-select">
                <option value="">Tất cả chuyên mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
                Tìm kiếm
            </button>
        </div>
    </form>
</div>

<!-- Posts Grid -->
<div class="posts-grid">
    @forelse($posts as $post)
        <article class="post-card">
            <div class="post-card-header">
                <h2 class="post-title">
                    <a href="{{ route('posts.show', $post->slug) }}">
                        {{ $post->title }}
                    </a>
                </h2>
                
                <div class="post-meta">
                    <div class="post-meta-item">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ $post->user->name }}</span>
                    </div>
                    
                    <div class="post-meta-item">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ $post->created_at->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="post-meta-item">
                        <i class="bi bi-clock"></i>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <a href="{{ route('categories.show', $post->category) }}" class="category-badge">
                        <i class="bi bi-tag"></i>
                        {{ $post->category->name }}
                    </a>
                </div>
            </div>
            
            <div class="post-card-body">
                @if($post->excerpt)
                    <p class="post-excerpt">{{ $post->excerpt }}</p>
                @endif
                
                <div class="post-card-footer">
                    <a href="{{ route('posts.show', $post->slug) }}" class="read-more-btn">
                        Đọc tiếp
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    
                    <div class="post-stats">
                        <div class="post-stat">
                            <i class="bi bi-eye"></i>
                            <span>{{ number_format($post->view_count) }}</span>
                        </div>
                        <div class="post-stat">
                            <i class="bi bi-chat"></i>
                            <span>{{ $post->comments->where('is_approved', true)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-journal-x"></i>
            </div>
            <h3 class="empty-state-title">Không tìm thấy bài viết</h3>
            <p class="empty-state-description">
                Hiện tại không có bài viết nào phù hợp với tiêu chí tìm kiếm của bạn.<br>
                Hãy thử tìm kiếm với từ khóa khác hoặc xem tất cả bài viết.
            </p>
            @if(request('search') || request('category'))
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i>
                    Xem tất cả bài viết
                </a>
            @endif
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($posts->hasPages())
    <div class="pagination-wrapper">
        <nav aria-label="Phân trang">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($posts->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                    @if ($page == $posts->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($posts->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif
@endsection

@section('sidebar')
<!-- Categories Widget -->
<div class="sidebar-widget">
    <div class="widget-header">
        <i class="bi bi-folder2-open"></i>
        Chuyên Mục
    </div>
    <div class="widget-body">
        <ul class="category-list">
            @foreach($categories as $category)
                <li class="category-item">
                    <a href="{{ route('categories.show', $category) }}" class="category-link">
                        <span class="category-name">
                            <i class="bi bi-tag"></i>
                            {{ $category->name }}
                        </span>
                        <span class="category-count">
                            {{ $category->posts_count ?? $category->posts->count() }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Recent Posts Widget -->
@if(isset($recentPosts) && $recentPosts->count() > 0)
<div class="sidebar-widget">
    <div class="widget-header">
        <i class="bi bi-clock-history"></i>
        Bài Viết Gần Đây
    </div>
    <div class="widget-body">
        <div class="recent-posts-list">
            @foreach($recentPosts as $recentPost)
                <div class="recent-post-item">
                    <h6 class="recent-post-title">
                        <a href="{{ route('posts.show', $recentPost->slug) }}">
                            {{ Str::limit($recentPost->title, 60) }}
                        </a>
                    </h6>
                    <div class="recent-post-meta">
                        <small class="text-muted">
                            <i class="bi bi-calendar3"></i>
                            {{ $recentPost->created_at->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Popular Posts Widget -->
@if(isset($popularPosts) && $popularPosts->count() > 0)
<div class="sidebar-widget">
    <div class="widget-header">
        <i class="bi bi-fire"></i>
        Bài Viết Phổ Biến
    </div>
    <div class="widget-body">
        <div class="popular-posts-list">
            @foreach($popularPosts as $popularPost)
                <div class="popular-post-item">
                    <h6 class="popular-post-title">
                        <a href="{{ route('posts.show', $popularPost->slug) }}">
                            {{ Str::limit($popularPost->title, 60) }}
                        </a>
                    </h6>
                    <div class="popular-post-stats">
                        <small class="text-muted">
                            <i class="bi bi-eye"></i> {{ number_format($popularPost->view_count) }} lượt xem
                        </small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
