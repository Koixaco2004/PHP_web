@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="mb-4">{{ $category->name }}</h1>
        
        @if($category->description)
            <div class="alert alert-info">
                {{ $category->description }}
            </div>
        @endif

        <!-- Danh sách bài viết trong chuyên mục -->
        @forelse($posts as $post)
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">
                            {{ $post->title }}
                        </a>
                    </h5>
                    <p class="card-text text-muted">
                        <small>
                            <i class="bi bi-person"></i> {{ $post->user->name }} | 
                            <i class="bi bi-calendar"></i> {{ $post->created_at->format('d/m/Y') }} |
                            <i class="bi bi-eye"></i> {{ $post->view_count }} lượt xem
                        </small>
                    </p>
                    @if($post->excerpt)
                        <p class="card-text">{{ $post->excerpt }}</p>
                    @endif
                    <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-primary">Đọc tiếp</a>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Chưa có bài viết nào trong chuyên mục này.
            </div>
        @endforelse

        <!-- Phân trang -->
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin chuyên mục</h5>
            </div>
            <div class="card-body">
                <h6>{{ $category->name }}</h6>
                @if($category->description)
                    <p class="text-muted">{{ $category->description }}</p>
                @endif
                <p class="mb-0">
                    <small class="text-muted">
                        {{ $posts->total() }} bài viết
                    </small>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
