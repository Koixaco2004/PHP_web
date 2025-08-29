@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Bài viết -->
        <article class="card mb-4">
            <div class="card-body">
                <h1 class="card-title">{{ $post->title }}</h1>
                
                <div class="text-muted mb-3">
                    <small>
                        <i class="bi bi-person"></i> {{ $post->user->name }} | 
                        <i class="bi bi-folder"></i> {{ $post->category->name }} | 
                        <i class="bi bi-calendar"></i> {{ $post->created_at->format('d/m/Y H:i') }} |
                        <i class="bi bi-eye"></i> {{ $post->view_count }} lượt xem
                    </small>
                </div>

                @if($post->excerpt)
                    <div class="lead mb-3">{{ $post->excerpt }}</div>
                @endif

                <div class="post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>
        </article>

        <!-- Bình luận -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Bình luận ({{ $post->comments->where('is_approved', true)->count() }})</h5>
            </div>
            <div class="card-body">
                @auth
                    <!-- Form bình luận -->
                    <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label for="content" class="form-label">Bình luận của bạn</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="3" required></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                @else
                    <div class="alert alert-info">
                        Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.
                    </div>
                @endauth

                <!-- Danh sách bình luận -->
                <div class="comments-list">
                    @forelse($post->comments->where('is_approved', true)->whereNull('parent_id') as $comment)
                        <div class="comment mb-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        {{ substr($comment->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="mb-1">{{ $comment->user->name }}</h6>
                                        <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1">{{ $comment->content }}</p>
                                    
                                    @auth
                                        <button class="btn btn-sm btn-outline-primary reply-btn" 
                                                data-comment-id="{{ $comment->id }}">
                                            Trả lời
                                        </button>
                                    @endauth

                                    <!-- Bình luận con -->
                                    @foreach($comment->children->where('is_approved', true) as $reply)
                                        <div class="reply mt-3 ms-4">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width: 30px; height: 30px;">
                                                        {{ substr($reply->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1 small">{{ $reply->user->name }}</h6>
                                                        <small class="text-muted">{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                                    </div>
                                                    <p class="mb-1 small">{{ $reply->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Chưa có bình luận nào.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Bài viết liên quan -->
        @if($relatedPosts->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Bài viết liên quan</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedPosts as $relatedPost)
                        <div class="mb-3">
                            <h6>
                                <a href="{{ route('posts.show', $relatedPost->slug) }}" class="text-decoration-none">
                                    {{ $relatedPost->title }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                {{ $relatedPost->created_at->format('d/m/Y') }}
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal trả lời bình luận -->
@auth
<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Trả lời bình luận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <input type="hidden" name="parent_id" id="parent_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reply_content" class="form-label">Nội dung trả lời</label>
                        <textarea class="form-control" id="reply_content" name="content" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Gửi trả lời</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const replyButtons = document.querySelectorAll('.reply-btn');
    const replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
    const parentIdInput = document.getElementById('parent_id');
    const replyContent = document.getElementById('reply_content');

    replyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            parentIdInput.value = commentId;
            replyContent.value = '';
            replyModal.show();
        });
    });
});
</script>
@endauth
@endsection
