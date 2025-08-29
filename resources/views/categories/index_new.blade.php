@extends('layouts.app')

@section('title', 'Quản lý danh mục')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pages/category-management.css') }}">
@endpush

@section('content')
<div class="category-management">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div>
                <h1 class="page-title">Quản lý danh mục</h1>
                <p class="page-subtitle">Tổ chức và sắp xếp các danh mục bài viết</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('categories.create') }}" class="btn-header-primary">
                    <i class="bi bi-plus-circle"></i>
                    Thêm danh mục mới
                </a>
            </div>
        </div>
    </div>

    <!-- Category Stats -->
    <div class="category-stats">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="bi bi-collection"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalCategories ?? 0 }}</h3>
                <p>Tổng danh mục</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $activeCategories ?? 0 }}</h3>
                <p>Đang hoạt động</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon inactive">
                <i class="bi bi-pause-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $inactiveCategories ?? 0 }}</h3>
                <p>Tạm dừng</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="category-content">
        <div class="category-main">
            <!-- Categories List -->
            <div class="category-list-container">
                <div class="category-list-header">
                    <h3 class="list-title">
                        <i class="bi bi-list-ul"></i>
                        Danh sách danh mục
                    </h3>
                    <div class="sort-info">
                        <i class="bi bi-info-circle"></i>
                        Kéo thả để sắp xếp thứ tự
                    </div>
                </div>
                <div class="categories-list" id="categoriesList">
                    @forelse($categories as $category)
                    <div class="category-item" data-id="{{ $category->id }}" draggable="true">
                        <div class="category-item-content">
                            <div class="drag-handle">
                                <i class="bi bi-grip-vertical"></i>
                            </div>
                            
                            <div class="category-icon">
                                <i class="bi bi-tag"></i>
                            </div>
                            
                            <div class="category-details">
                                <div class="category-name">{{ $category->name }}</div>
                                @if($category->description)
                                <div class="category-description">{{ Str::limit($category->description, 100) }}</div>
                                @endif
                                <div class="category-meta">
                                    <span>
                                        <i class="bi bi-file-earmark-text"></i>
                                        {{ $category->posts_count }} bài viết
                                    </span>
                                    <span>
                                        <i class="bi bi-calendar"></i>
                                        {{ $category->created_at->format('d/m/Y') }}
                                    </span>
                                    <span>
                                        <i class="bi bi-link-45deg"></i>
                                        /{{ $category->slug }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="category-status">
                                <span class="status-badge {{ $category->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $category->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                </span>
                                
                                <div class="category-actions">
                                    <a href="{{ route('categories.edit', $category) }}" 
                                       class="btn-category btn-category-edit"
                                       title="Chỉnh sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <button class="btn-category btn-category-toggle" 
                                            onclick="toggleStatus({{ $category->id }})"
                                            title="{{ $category->is_active ? 'Tạm dừng' : 'Kích hoạt' }}">
                                        <i class="bi bi-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                    
                                    @if($category->posts_count == 0)
                                    <button class="btn-category btn-category-delete" 
                                            onclick="deleteCategory({{ $category->id }})"
                                            title="Xóa danh mục">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-collection"></i>
                        </div>
                        <h3 class="empty-state-title">Chưa có danh mục nào</h3>
                        <p class="empty-state-description">
                            Hãy tạo danh mục đầu tiên để bắt đầu tổ chức nội dung.
                        </p>
                        <a href="{{ route('categories.create') }}" class="empty-state-action">
                            <i class="bi bi-plus-circle"></i>
                            Tạo danh mục đầu tiên
                        </a>
                    </div>
                    @endforelse
                </div>
                
                <!-- Drop Zone -->
                <div class="drop-zone" id="dropZone">
                    <div class="drop-zone-icon">
                        <i class="bi bi-arrow-down-circle"></i>
                    </div>
                    <div>Thả danh mục vào đây để sắp xếp</div>
                </div>
            </div>
        </div>

        <div class="category-sidebar">
            <!-- Quick Add Form -->
            <div class="quick-add-form">
                <div class="form-header">
                    <h3 class="form-title">
                        <i class="bi bi-plus-square"></i>
                        Thêm nhanh danh mục
                    </h3>
                </div>
                <div class="form-body">
                    <form action="{{ route('categories.store') }}" method="POST" id="quickAddForm">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Tên danh mục</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-input" 
                                   placeholder="Nhập tên danh mục..." 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Mô tả (tùy chọn)</label>
                            <textarea name="description" 
                                      class="form-textarea" 
                                      placeholder="Mô tả ngắn về danh mục..."></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-form btn-form-primary">
                                <i class="bi bi-check-circle"></i>
                                Thêm danh mục
                            </button>
                            <button type="reset" class="btn-form btn-form-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                                Đặt lại
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category Stats Widget -->
            <div class="stats-widget">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="bi bi-graph-up"></i>
                        Thống kê chi tiết
                    </h3>
                </div>
                <div class="widget-body">
                    <div class="stats-list">
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="bi bi-file-earmark-text"></i>
                                Tổng bài viết
                            </div>
                            <div class="stat-value">{{ $totalPosts ?? 0 }}</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="bi bi-eye"></i>
                                Lượt xem hôm nay
                            </div>
                            <div class="stat-value">{{ $todayViews ?? 0 }}</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="bi bi-calendar-week"></i>
                                Bài viết tuần này
                            </div>
                            <div class="stat-value">{{ $weekPosts ?? 0 }}</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="bi bi-chat-dots"></i>
                                Bình luận mới
                            </div>
                            <div class="stat-value">{{ $newComments ?? 0 }}</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="bi bi-people"></i>
                                Người dùng hoạt động
                            </div>
                            <div class="stat-value">{{ $activeUsers ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Widget -->
            <div class="stats-widget">
                <div class="widget-header">
                    <h3 class="widget-title">
                        <i class="bi bi-clock-history"></i>
                        Hoạt động gần đây
                    </h3>
                </div>
                <div class="widget-body">
                    <div class="stats-list">
                        @forelse($recentActivities ?? [] as $activity)
                        <div class="stat-item">
                            <div class="stat-label">
                                <i class="bi bi-{{ $activity['icon'] }}"></i>
                                {{ $activity['description'] }}
                            </div>
                            <div class="stat-value">{{ $activity['time'] }}</div>
                        </div>
                        @empty
                        <div class="empty-widget">
                            <i class="bi bi-activity" style="font-size: 2rem; opacity: 0.5;"></i>
                            <p style="margin: 0.5rem 0 0; color: var(--text-secondary); font-size: 0.9rem;">
                                Chưa có hoạt động nào
                            </p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save Order Button -->
<button class="save-order-btn" id="saveOrderBtn" onclick="saveOrder()">
    <i class="bi bi-check-circle"></i>
    Lưu thứ tự
</button>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

@push('scripts')
<script>
// Global variables
let draggedElement = null;
let originalOrder = [];
let currentOrder = [];
let hasChanges = false;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeDragAndDrop();
    initializeOriginalOrder();
    initializeFormSubmission();
});

// Initialize drag and drop functionality
function initializeDragAndDrop() {
    const categoriesList = document.getElementById('categoriesList');
    const categoryItems = document.querySelectorAll('.category-item');
    const dropZone = document.getElementById('dropZone');

    categoryItems.forEach(item => {
        // Drag start
        item.addEventListener('dragstart', function(e) {
            draggedElement = this;
            this.classList.add('dragging');
            
            // Set drag data
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.outerHTML);
            
            // Show drop zone
            dropZone.classList.add('active');
        });

        // Drag end
        item.addEventListener('dragend', function(e) {
            this.classList.remove('dragging');
            draggedElement = null;
            
            // Hide drop zone
            dropZone.classList.remove('active');
            
            // Remove all drag-over classes
            document.querySelectorAll('.drag-over').forEach(el => {
                el.classList.remove('drag-over');
            });
        });

        // Drag over
        item.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            
            if (this !== draggedElement) {
                this.classList.add('drag-over');
            }
        });

        // Drag leave
        item.addEventListener('dragleave', function(e) {
            this.classList.remove('drag-over');
        });

        // Drop
        item.addEventListener('drop', function(e) {
            e.preventDefault();
            
            if (this !== draggedElement) {
                // Determine drop position
                const rect = this.getBoundingClientRect();
                const midpoint = rect.top + rect.height / 2;
                
                if (e.clientY < midpoint) {
                    // Insert before
                    categoriesList.insertBefore(draggedElement, this);
                } else {
                    // Insert after
                    categoriesList.insertBefore(draggedElement, this.nextSibling);
                }
                
                updateOrder();
            }
            
            this.classList.remove('drag-over');
        });
    });

    // Drop zone functionality
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        // Append to end
        categoriesList.appendChild(draggedElement);
        updateOrder();
        this.classList.remove('active');
    });
}

// Initialize original order
function initializeOriginalOrder() {
    const items = document.querySelectorAll('.category-item');
    originalOrder = Array.from(items).map(item => item.dataset.id);
    currentOrder = [...originalOrder];
}

// Update order after drag and drop
function updateOrder() {
    const items = document.querySelectorAll('.category-item');
    currentOrder = Array.from(items).map(item => item.dataset.id);
    
    // Check if order has changed
    hasChanges = !arraysEqual(originalOrder, currentOrder);
    
    // Show/hide save button
    const saveBtn = document.getElementById('saveOrderBtn');
    if (hasChanges) {
        saveBtn.classList.add('show');
    } else {
        saveBtn.classList.remove('show');
    }
}

// Check if two arrays are equal
function arraysEqual(a, b) {
    return JSON.stringify(a) === JSON.stringify(b);
}

// Save new order
function saveOrder() {
    if (!hasChanges) return;
    
    showLoading();
    
    const formData = new FormData();
    formData.append('order', JSON.stringify(currentOrder));
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch('/admin/categories/reorder', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            // Update original order
            originalOrder = [...currentOrder];
            hasChanges = false;
            
            // Hide save button
            document.getElementById('saveOrderBtn').classList.remove('show');
            
            // Show success message
            showSuccessMessage('Đã lưu thứ tự danh mục thành công!');
        } else {
            showErrorMessage('Có lỗi xảy ra khi lưu thứ tự danh mục');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showErrorMessage('Có lỗi xảy ra khi lưu thứ tự danh mục');
    });
}

// Toggle category status
function toggleStatus(categoryId) {
    showLoading();
    
    const formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch(`/categories/${categoryId}/toggle`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            location.reload();
        } else {
            showErrorMessage('Có lỗi xảy ra khi thay đổi trạng thái danh mục');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showErrorMessage('Có lỗi xảy ra khi thay đổi trạng thái danh mục');
    });
}

// Delete category
function deleteCategory(categoryId) {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục này? Hành động này không thể hoàn tác.')) {
        showLoading();
        
        const formData = new FormData();
        formData.append('_method', 'DELETE');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        fetch(`/categories/${categoryId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                location.reload();
            } else {
                showErrorMessage('Có lỗi xảy ra khi xóa danh mục');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showErrorMessage('Có lỗi xảy ra khi xóa danh mục');
        });
    }
}

// Initialize form submission
function initializeFormSubmission() {
    const form = document.getElementById('quickAddForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        showLoading();
        
        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showSuccessMessage('Đã thêm danh mục thành công!');
                form.reset();
                // Reload page to show new category
                setTimeout(() => location.reload(), 1000);
            } else {
                showErrorMessage(data.message || 'Có lỗi xảy ra khi thêm danh mục');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showErrorMessage('Có lỗi xảy ra khi thêm danh mục');
        });
    });
}

// Utility functions
function showLoading() {
    document.getElementById('loadingOverlay').classList.add('show');
}

function hideLoading() {
    document.getElementById('loadingOverlay').classList.remove('show');
}

function showSuccessMessage(message) {
    // Simple alert for now - can be enhanced with toast notifications
    alert(message);
}

function showErrorMessage(message) {
    alert(message);
}

// Prevent form reset when page reloads
window.addEventListener('beforeunload', function(e) {
    if (hasChanges) {
        e.preventDefault();
        e.returnValue = 'Bạn có thay đổi chưa được lưu. Bạn có chắc muốn rời khỏi trang?';
    }
});
</script>
@endpush
@endsection
