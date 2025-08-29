@extends('layouts.app')

@section('title', $post->title . ' - VN News')

@section('additional_css')
    <link rel="stylesheet" href="{{ asset('css/pages/post-detail.css') }}">
@endsection

@section('content')
<!-- Reading Progress Bar -->
<div class="reading-progress">
    <div class="reading-progress-bar" id="progressBar"></div>
</div>

<!-- Post Header -->
<div class="post-detail-header">
    <div class="post-detail-header-content">
        <!-- Breadcrumb -->
        <nav class="post-breadcrumb">
            <a href="{{ route('home') }}">
                <i class="bi bi-house"></i> Trang chủ
            </a>
            <span class="post-breadcrumb-separator">
                <i class="bi bi-chevron-right"></i>
            </span>
            <a href="{{ route('categories.show', $post->category) }}">
                {{ $post->category->name }}
            </a>
            <span class="post-breadcrumb-separator">
                <i class="bi bi-chevron-right"></i>
            </span>
            <span>{{ Str::limit($post->title, 50) }}</span>
        </nav>

        <!-- Post Title -->
        <h1 class="post-detail-title">{{ $post->title }}</h1>

        <!-- Post Meta -->
        <div class="post-detail-meta">
            <div class="post-meta-detail">
                <i class="bi bi-person-circle"></i>
                <span>{{ $post->user->name }}</span>
            </div>
            
            <div class="post-meta-detail">
                <i class="bi bi-calendar3"></i>
                <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
            </div>
            
            <div class="post-meta-detail">
                <i class="bi bi-clock"></i>
                <span>{{ $post->created_at->diffForHumans() }}</span>
            </div>
            
            <div class="post-meta-detail">
                <i class="bi bi-eye"></i>
                <span>{{ number_format($post->view_count) }} lượt xem</span>
            </div>
            
            <div class="post-meta-detail">
                <i class="bi bi-chat"></i>
                <span>{{ $post->comments->where('is_approved', true)->count() }} bình luận</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Article -->
<article class="post-article">
    <div class="post-content-wrapper">
        @if($post->excerpt)
            <div class="post-excerpt">
                <p class="lead">{{ $post->excerpt }}</p>
            </div>
        @endif

        <div class="post-content">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Author Info -->
        <div class="author-info">
            <div class="author-avatar">
                {{ strtoupper(substr($post->user->name, 0, 1)) }}
            </div>
            <div class="author-details">
                <h4 class="author-name">{{ $post->user->name }}</h4>
                <div class="author-role">
                    @if($post->user->isAdmin())
                        <i class="bi bi-star-fill"></i> Biên tập viên
                    @else
                        <i class="bi bi-person"></i> Tác giả
                    @endif
                </div>
                <div class="author-bio">
                    Tác giả với nhiều năm kinh nghiệm trong lĩnh vực báo chí và truyền thông.
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Social Sharing -->
<div class="social-sharing">
    <div class="sharing-title">
        <i class="bi bi-share"></i>
        Chia sẻ bài viết
    </div>
    <div class="sharing-buttons">
        <button class="share-btn share-btn-facebook" onclick="shareOnFacebook()">
            <i class="bi bi-facebook"></i>
            Facebook
        </button>
        
        <button class="share-btn share-btn-twitter" onclick="shareOnTwitter()">
            <i class="bi bi-twitter"></i>
            Twitter
        </button>
        
        <button class="share-btn share-btn-linkedin" onclick="shareOnLinkedIn()">
            <i class="bi bi-linkedin"></i>
            LinkedIn
        </button>
        
        <button class="share-btn share-btn-copy" onclick="copyToClipboard()">
            <i class="bi bi-clipboard"></i>
            Copy Link
        </button>
    </div>
</div>

<!-- Comments Section -->
<div class="comments-section">
    <div class="comments-header">
        <i class="bi bi-chat-dots"></i>
        Bình luận ({{ $post->comments->where('is_approved', true)->count() }})
    </div>
    
    <div class="comments-body">
        @auth
            <!-- Comment Form -->
            <div class="comment-form">
                <div class="comment-form-title">
                    <i class="bi bi-pencil-square"></i>
                    Để lại bình luận của bạn
                </div>
                
                <form method="POST" action="{{ route('comments.store', $post) }}">
                    @csrf
                    <div class="form-group">
                        <label for="content" class="form-label">Nội dung bình luận *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  placeholder="Hãy chia sẻ suy nghĩ của bạn về bài viết này..."
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i>
                        Gửi bình luận
                    </button>
                </form>
            </div>
        @else
            <div class="comment-form">
                <div class="comment-form-title">
                    <i class="bi bi-info-circle"></i>
                    Đăng nhập để bình luận
                </div>
                <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                    Bạn cần đăng nhập để có thể để lại bình luận cho bài viết này.
                </p>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Đăng nhập
                </a>
            </div>
        @endauth

        <!-- Comments List -->
        @if($post->comments->where('is_approved', true)->count() > 0)
            <div class="comments-list">
                @foreach($post->comments->where('is_approved', true)->whereNull('parent_id') as $comment)
                    <div class="comment-item">
                        <div class="comment-avatar">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        
                        <div class="comment-content">
                            <div class="comment-header">
                                <div>
                                    <div class="comment-author">{{ $comment->user->name }}</div>
                                    <div class="comment-date">
                                        <i class="bi bi-clock"></i>
                                        {{ $comment->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="comment-text">
                                {{ $comment->content }}
                            </div>
                            
                            @auth
                                <button class="btn btn-outline reply-btn" 
                                        data-comment-id="{{ $comment->id }}"
                                        style="margin-top: 1rem; font-size: 0.85rem;">
                                    <i class="bi bi-reply"></i>
                                    Trả lời
                                </button>
                            @endauth

                            <!-- Replies -->
                            @foreach($comment->children->where('is_approved', true) as $reply)
                                <div class="comment-item" style="margin-left: 2rem; margin-top: 1rem; background-color: var(--light-color);">
                                    <div class="comment-avatar" style="width: 40px; height: 40px; font-size: 0.9rem;">
                                        {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                    </div>
                                    
                                    <div class="comment-content">
                                        <div class="comment-header">
                                            <div>
                                                <div class="comment-author">{{ $reply->user->name }}</div>
                                                <div class="comment-date">
                                                    <i class="bi bi-clock"></i>
                                                    {{ $reply->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="comment-text">
                                            {{ $reply->content }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-chat-square"></i>
                </div>
                <h3 class="empty-state-title">Chưa có bình luận</h3>
                <p class="empty-state-description">
                    Hãy là người đầu tiên bình luận về bài viết này!
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

@endsection

@section('sidebar')
<!-- Related Posts -->
@if(isset($relatedPosts) && $relatedPosts->count() > 0)
<div class="related-posts">
    <div class="related-posts-header">
        <i class="bi bi-journal-text"></i>
        Bài Viết Liên Quan
    </div>
    <div class="related-posts-grid">
        @foreach($relatedPosts as $relatedPost)
            <div class="related-post-card">
                <div class="related-post-content">
                    <h6 class="related-post-title">
                        <a href="{{ route('posts.show', $relatedPost->slug) }}">
                            {{ $relatedPost->title }}
                        </a>
                    </h6>
                    <div class="related-post-meta">
                        <div class="related-post-date">
                            <i class="bi bi-calendar3"></i>
                            {{ $relatedPost->created_at->format('d/m/Y') }}
                        </div>
                        <div class="related-post-views">
                            <i class="bi bi-eye"></i>
                            {{ number_format($relatedPost->view_count) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Category Posts -->
<div class="sidebar-widget">
    <div class="widget-header">
        <i class="bi bi-folder"></i>
        Cùng Chuyên Mục
    </div>
    <div class="widget-body">
        <div class="category-posts-list">
            @if(isset($categoryPosts))
                @foreach($categoryPosts->take(5) as $categoryPost)
                    <div class="category-post-item">
                        <h6 class="category-post-title">
                            <a href="{{ route('posts.show', $categoryPost->slug) }}">
                                {{ Str::limit($categoryPost->title, 60) }}
                            </a>
                        </h6>
                        <div class="category-post-meta">
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i>
                                {{ $categoryPost->created_at->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Back to Top -->
<div class="sidebar-widget">
    <div class="widget-body text-center">
        <button class="btn btn-outline" onclick="scrollToTop()" id="backToTopBtn" style="display: none;">
            <i class="bi bi-arrow-up"></i>
            Về đầu trang
        </button>
    </div>
</div>
@endsection

@section('additional_js')
<!-- Reply Modal -->
@auth
<div class="modal fade" id="replyModal" tabindex="-1" style="z-index: 1050;">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: var(--border-radius); border: none; box-shadow: var(--shadow-lg);">
            <div class="modal-header" style="background: var(--primary-color); color: white; border-bottom: none;">
                <h5 class="modal-title">
                    <i class="bi bi-reply"></i>
                    Trả lời bình luận
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <input type="hidden" name="parent_id" id="parent_id">
                <div class="modal-body" style="padding: 2rem;">
                    <div class="form-group">
                        <label for="reply_content" class="form-label" style="font-weight: 600;">Nội dung trả lời *</label>
                        <textarea class="form-control" 
                                  id="reply_content" 
                                  name="content" 
                                  rows="4" 
                                  placeholder="Nhập nội dung trả lời..."
                                  required></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color); padding: 1rem 2rem;">
                    <button type="button" class="btn btn-outline" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i>
                        Hủy
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i>
                        Gửi trả lời
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reading Progress Bar
    const progressBar = document.getElementById('progressBar');
    const backToTopBtn = document.getElementById('backToTopBtn');
    
    function updateReadingProgress() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        
        if (progressBar) {
            progressBar.style.width = scrolled + '%';
        }
        
        // Show/hide back to top button
        if (backToTopBtn) {
            if (winScroll > 300) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        }
    }
    
    window.addEventListener('scroll', updateReadingProgress);
    
    // Reply functionality
    @auth
    const replyButtons = document.querySelectorAll('.reply-btn');
    const replyModal = document.getElementById('replyModal');
    const parentIdInput = document.getElementById('parent_id');
    const replyContent = document.getElementById('reply_content');
    
    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            if (parentIdInput && replyContent) {
                parentIdInput.value = commentId;
                replyContent.value = '';
                
                // Show modal using Bootstrap
                const modal = new bootstrap.Modal(replyModal);
                modal.show();
            }
        });
    });
    @endauth
    
    // Social Sharing Functions
    window.shareOnFacebook = function() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ addslashes($post->title) }}');
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    };
    
    window.shareOnTwitter = function() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ addslashes($post->title) }}');
        window.open(`https://twitter.com/intent/tweet?text=${title}&url=${url}`, '_blank', 'width=600,height=400');
    };
    
    window.shareOnLinkedIn = function() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent('{{ addslashes($post->title) }}');
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
    };
    
    window.copyToClipboard = function() {
        const url = window.location.href;
        
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(function() {
                showCopyMessage('Link đã được sao chép!');
            }, function(err) {
                console.error('Could not copy text: ', err);
                fallbackCopyTextToClipboard(url);
            });
        } else {
            fallbackCopyTextToClipboard(url);
        }
    };
    
    function fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showCopyMessage('Link đã được sao chép!');
            } else {
                showCopyMessage('Không thể sao chép link!');
            }
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
            showCopyMessage('Không thể sao chép link!');
        }
        
        document.body.removeChild(textArea);
    }
    
    function showCopyMessage(message) {
        const copyBtn = document.querySelector('.share-btn-copy');
        const originalText = copyBtn.innerHTML;
        
        copyBtn.innerHTML = '<i class="bi bi-check"></i> ' + message;
        copyBtn.style.background = 'var(--success-color)';
        copyBtn.style.color = 'white';
        
        setTimeout(() => {
            copyBtn.innerHTML = originalText;
            copyBtn.style.background = 'var(--secondary-color)';
            copyBtn.style.color = 'var(--text-primary)';
        }, 2000);
    }
    
    // Scroll to top function
    window.scrollToTop = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
});
</script>
@endsection
