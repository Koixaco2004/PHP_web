@extends('layouts.app')

@section('title', 'Quản lý bài viết')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/post-management.css') }}">
@endpush

@section('content')
<div class="post-management">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Quản lý bài viết</h1>
                <p class="page-subtitle">Quản lý và tổ chức tất cả bài viết trên website</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('posts.create') }}" class="btn-header-primary">
                    <i class="bi bi-plus-circle"></i>
                    Tạo bài viết mới
                </a>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="filters-section">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="bi bi-funnel"></i>
                Bộ lọc và tìm kiếm
            </h3>
            <button class="filters-toggle" onclick="toggleFilters()">
                <i class="bi bi-chevron-up" id="filterToggleIcon"></i>
                Thu gọn
            </button>
        </div>
        <form method="GET" action="{{ route('posts.index') }}" id="filtersForm">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">Tìm kiếm</label>
                    <div class="filter-search">
                        <i class="bi bi-search"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Tìm kiếm theo tiêu đề, nội dung..." 
                               class="filter-input">
                    </div>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Trạng thái</label>
                    <select name="status" class="filter-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Đã lưu trữ</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Chuyên mục</label>
                    <select name="category" class="filter-select">
                        <option value="">Tất cả chuyên mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Sắp xếp</label>
                    <select name="sort" class="filter-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Tên A-Z</option>
                        <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Lượt xem</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <button type="submit" class="btn-filter">
                        <i class="bi bi-search"></i>
                        Lọc
                    </button>
                    <a href="{{ route('posts.index') }}" class="btn-filter btn-filter-clear">
                        <i class="bi bi-arrow-clockwise"></i>
                        Đặt lại
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Bulk Actions Bar -->
    <div class="bulk-actions-bar" id="bulkActionsBar">
        <div class="bulk-selection-info">
            <span>Đã chọn:</span>
            <span class="bulk-selection-count" id="selectedCount">0</span>
            <span>bài viết</span>
        </div>
        <div class="bulk-actions">
            <button class="btn-bulk btn-bulk-publish" onclick="bulkAction('publish')">
                <i class="bi bi-check-circle"></i>
                Xuất bản
            </button>
            <button class="btn-bulk btn-bulk-draft" onclick="bulkAction('draft')">
                <i class="bi bi-clock"></i>
                Chuyển về nháp
            </button>
            <button class="btn-bulk btn-bulk-delete" onclick="bulkAction('delete')">
                <i class="bi bi-trash"></i>
                Xóa
            </button>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="posts-table-container">
        @if($posts->count() > 0)
        <table class="posts-table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selectAll" class="post-checkbox">
                    </th>
                    <th>Bài viết</th>
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
                        <input type="checkbox" class="post-checkbox post-select" value="{{ $post->id }}">
                    </td>
                    <td class="post-title-cell">
                        <div style="display: flex; align-items: flex-start; gap: 1rem;">
                            <div class="post-thumbnail">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div>
                                <a href="{{ route('posts.show', $post->slug) }}" 
                                   class="post-title-link" 
                                   target="_blank">
                                    {{ $post->title }}
                                </a>
                                @if($post->excerpt)
                                <p class="post-excerpt">{{ Str::limit($post->excerpt, 100) }}</p>
                                @endif
                                <div class="post-meta">
                                    <span><i class="bi bi-calendar"></i> {{ $post->created_at->format('d/m/Y H:i') }}</span>
                                    @if($post->updated_at != $post->created_at)
                                    <span><i class="bi bi-pencil"></i> {{ $post->updated_at->format('d/m/Y H:i') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="#" class="category-tag">{{ $post->category->name }}</a>
                    </td>
                    <td>
                        <div class="author-info">
                            <div class="author-avatar">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                            {{ $post->user->name }}
                        </div>
                    </td>
                    <td>
                        <span class="post-status-badge status-{{ $post->status }}">
                            {{ $post->status == 'published' ? 'Đã xuất bản' : ($post->status == 'draft' ? 'Bản nháp' : 'Lưu trữ') }}
                        </span>
                    </td>
                    <td>
                        <div class="view-count">
                            <i class="bi bi-eye"></i>
                            {{ number_format($post->view_count ?? 0) }}
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            <span class="date-primary">{{ $post->created_at->format('d/m/Y') }}</span>
                            {{ $post->created_at->format('H:i') }}
                        </div>
                    </td>
                    <td>
                        <div class="post-actions">
                            <a href="{{ route('posts.edit', $post) }}" 
                               class="btn-action btn-action-edit"
                               title="Chỉnh sửa">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('posts.show', $post->slug) }}" 
                               class="btn-action btn-action-view"
                               target="_blank"
                               title="Xem bài viết">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button class="btn-action btn-action-more" onclick="toggleDropdown({{ $post->id }})">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu" id="dropdown{{ $post->id }}">
                                @if($post->status == 'draft')
                                <a href="#" class="dropdown-item" onclick="changeStatus({{ $post->id }}, 'published')">
                                    <i class="bi bi-check-circle"></i>
                                    Xuất bản
                                </a>
                                @else
                                <a href="#" class="dropdown-item" onclick="changeStatus({{ $post->id }}, 'draft')">
                                    <i class="bi bi-clock"></i>
                                    Chuyển về nháp
                                </a>
                                @endif
                                <a href="#" class="dropdown-item" onclick="duplicatePost({{ $post->id }})">
                                    <i class="bi bi-files"></i>
                                    Nhân bản
                                </a>
                                <a href="#" class="dropdown-item danger" onclick="deletePost({{ $post->id }})">
                                    <i class="bi bi-trash"></i>
                                    Xóa bài viết
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h3 class="empty-state-title">Chưa có bài viết nào</h3>
            <p class="empty-state-description">
                Hãy tạo bài viết đầu tiên để bắt đầu chia sẻ nội dung với độc giả của bạn.
            </p>
            <a href="{{ route('posts.create') }}" class="empty-state-action">
                <i class="bi bi-plus-circle"></i>
                Tạo bài viết đầu tiên
            </a>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="pagination-container">
        {{ $posts->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

@push('scripts')
<script>
// Global variables
let selectedPosts = new Set();

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    initializeEventListeners();
    updateBulkActionsBar();
});

// Initialize event listeners
function initializeEventListeners() {
    // Select All checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.post-select');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            if (this.checked) {
                selectedPosts.add(parseInt(checkbox.value));
            } else {
                selectedPosts.delete(parseInt(checkbox.value));
            }
        });
        updateBulkActionsBar();
    });

    // Individual checkboxes
    document.querySelectorAll('.post-select').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                selectedPosts.add(parseInt(this.value));
            } else {
                selectedPosts.delete(parseInt(this.value));
            }
            updateBulkActionsBar();
            updateSelectAllCheckbox();
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.btn-action-more')) {
            document.querySelectorAll('.dropdown-menu').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });
}

// Update bulk actions bar
function updateBulkActionsBar() {
    const bulkBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    
    selectedCount.textContent = selectedPosts.size;
    
    if (selectedPosts.size > 0) {
        bulkBar.classList.add('show');
    } else {
        bulkBar.classList.remove('show');
    }
}

// Update select all checkbox
function updateSelectAllCheckbox() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const totalCheckboxes = document.querySelectorAll('.post-select').length;
    
    if (selectedPosts.size === totalCheckboxes) {
        selectAllCheckbox.checked = true;
        selectAllCheckbox.indeterminate = false;
    } else if (selectedPosts.size > 0) {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = true;
    } else {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
    }
}

// Toggle filters visibility
function toggleFilters() {
    const filtersGrid = document.querySelector('.filters-grid');
    const toggleIcon = document.getElementById('filterToggleIcon');
    const toggleButton = document.querySelector('.filters-toggle');
    
    if (filtersGrid.style.display === 'none' || !filtersGrid.style.display) {
        filtersGrid.style.display = 'grid';
        toggleIcon.className = 'bi bi-chevron-up';
        toggleButton.innerHTML = '<i class="bi bi-chevron-up"></i> Thu gọn';
    } else {
        filtersGrid.style.display = 'none';
        toggleIcon.className = 'bi bi-chevron-down';
        toggleButton.innerHTML = '<i class="bi bi-chevron-down"></i> Mở rộng';
    }
}

// Toggle dropdown menu
function toggleDropdown(postId) {
    const dropdown = document.getElementById('dropdown' + postId);
    const isVisible = dropdown.classList.contains('show');
    
    // Close all dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.classList.remove('show');
    });
    
    // Toggle current dropdown
    if (!isVisible) {
        dropdown.classList.add('show');
    }
}

// Bulk actions
function bulkAction(action) {
    if (selectedPosts.size === 0) {
        alert('Vui lòng chọn ít nhất một bài viết');
        return;
    }
    
    let confirmMessage = '';
    switch (action) {
        case 'publish':
            confirmMessage = `Bạn có chắc chắn muốn xuất bản ${selectedPosts.size} bài viết đã chọn?`;
            break;
        case 'draft':
            confirmMessage = `Bạn có chắc chắn muốn chuyển ${selectedPosts.size} bài viết về trạng thái nháp?`;
            break;
        case 'delete':
            confirmMessage = `Bạn có chắc chắn muốn xóa ${selectedPosts.size} bài viết đã chọn? Hành động này không thể hoàn tác.`;
            break;
    }
    
    if (confirm(confirmMessage)) {
        showLoading();
        
        const formData = new FormData();
        formData.append('action', action);
        formData.append('posts', JSON.stringify([...selectedPosts]));
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch('/admin/posts/bulk-action', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra: ' + (data.message || 'Thao tác thất bại'));
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }
}

// Change post status
function changeStatus(postId, status) {
    showLoading();
    
    const formData = new FormData();
    formData.append('status', status);
    formData.append('_method', 'PATCH');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch(`/posts/${postId}/status`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            location.reload();
        } else {
            alert('Có lỗi xảy ra khi thay đổi trạng thái bài viết');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi thay đổi trạng thái bài viết');
    });
}

// Delete post
function deletePost(postId) {
    if (confirm('Bạn có chắc chắn muốn xóa bài viết này? Hành động này không thể hoàn tác.')) {
        showLoading();
        
        const formData = new FormData();
        formData.append('_method', 'DELETE');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch(`/posts/${postId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra khi xóa bài viết');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa bài viết');
        });
    }
}

// Duplicate post
function duplicatePost(postId) {
    if (confirm('Bạn có muốn nhân bản bài viết này?')) {
        showLoading();
        
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch(`/posts/${postId}/duplicate`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra khi nhân bản bài viết');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi nhân bản bài viết');
        });
    }
}

// Show loading overlay
function showLoading() {
    document.getElementById('loadingOverlay').classList.add('show');
}

// Hide loading overlay
function hideLoading() {
    document.getElementById('loadingOverlay').classList.remove('show');
}

// Auto-submit form on filter change
document.querySelectorAll('.filter-select').forEach(select => {
    select.addEventListener('change', function() {
        document.getElementById('filtersForm').submit();
    });
});
</script>
@endpush
@endsection
