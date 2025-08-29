@extends('layouts.app')

@section('title', 'Trang chủ - Website Tin Tức')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="mb-4">Tin tức mới nhất</h1>
        
        <!-- Form tìm kiếm -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('home') }}" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bài viết..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="">Tất cả chuyên mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danh sách bài viết -->
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
                            <i class="bi bi-folder"></i> 
                            <a href="{{ route('categories.show', $post->category) }}" class="text-decoration-none">
                                {{ $post->category->name }}
                            </a> | 
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
                Không có bài viết nào được tìm thấy.
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
                <h5 class="mb-0">Chuyên mục</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('categories.show', $category) }}" 
                               class="text-decoration-none">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
