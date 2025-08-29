@extends('layouts.app')

@section('title', 'Quản lý chuyên mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quản lý chuyên mục</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Thêm chuyên mục mới</a>
</div>

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên chuyên mục</th>
                            <th>Mô tả</th>
                            <th>Số bài viết</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description ?: 'Không có mô tả' }}</td>
                                <td>{{ $category->posts_count }}</td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Không hoạt động</span>
                                    @endif
                                </td>
                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                            Sửa
                                        </a>
                                        @if($category->posts_count == 0)
                                            <form method="POST" action="{{ route('categories.destroy', $category) }}" 
                                                  onsubmit="return confirm('Bạn có chắc muốn xóa chuyên mục này?')" 
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Xóa</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }}
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">Chưa có chuyên mục nào.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Tạo chuyên mục đầu tiên</a>
            </div>
        @endif
    </div>
</div>
@endsection
