@extends('layouts.app')

@section('title', 'Quản lý chuyên mục')

@php
    use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-900 rounded-xl shadow-lg p-8 mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 rounded-xl flex items-center justify-center mr-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-4xl font-heading font-bold text-white">Quản lý Chuyên mục</h1>
                <p class="text-primary-100 dark:text-primary-200 mt-2">Tạo và phân loại nội dung website</p>
            </div>
        </div>
        <div class="hidden lg:flex items-center space-x-3">
            <a href="{{ route('categories.create') }}" class="bg-white text-primary-600 hover:bg-primary-50 px-6 py-3 rounded-lg font-semibold flex items-center transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm chuyên mục
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Tổng chuyên mục</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400-dark">{{ $categories->total() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Đang hoạt động</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400-dark">{{ $categories->where('is_active', true)->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Tổng bài viết</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400-dark">{{ $categories->sum('posts_count') }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-secondary-600 dark:text-gray-300 mb-1">Chuyên mục trống</p>
                <p class="text-2xl font-bold text-primary-600 dark:text-primary-400-dark">{{ $categories->where('posts_count', 0)->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 overflow-hidden">
    @if($categories->count() > 0)
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-secondary-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-secondary-900 dark:text-primary-400-dark flex items-center">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Danh sách Chuyên mục
                </h2>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-secondary-600 dark:text-gray-300">
                        Hiển thị {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} của {{ $categories->total() }} chuyên mục
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead class="bg-secondary-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-64">Chuyên mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-80">Mô tả</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-24">Bài viết</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-28">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-24">Ngày tạo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-32">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-secondary-200 dark:divide-gray-700" id="categoriesTable">
                    @foreach($categories as $index => $category)
                        <tr class="category-row hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-secondary-900 dark:text-primary-400-dark category-name">{{ $category->name }}</div>
                                        <div class="text-sm text-secondary-500 dark:text-gray-400">ID: {{ $category->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 w-80">
                                <div class="text-sm text-secondary-900 dark:text-gray-300 category-description">
                                    {{ $category->description ?: 'Không có mô tả' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap w-24">
                               <div class="flex items-center">
                                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->posts_count > 0 ? 'bg-primary-100 dark:bg-primary-900-dark text-primary-800 dark:text-primary-200-dark' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                       {{ $category->posts_count }} BV
                                   </span>
                               </div>
                           </td>
                            <td class="px-6 py-4 whitespace-nowrap w-28">
                                @if($category->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900-dark text-primary-800 dark:text-primary-200-dark">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        HD
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        KHD
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-secondary-500 dark:text-gray-300 w-24">
                                {{ $category->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('categories.show', $category) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors duration-200"
                                       title="Xem chuyên mục">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    <a href="{{ route('categories.edit', $category) }}" 
                                       class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300 transition-colors duration-200"
                                       title="Chỉnh sửa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    @if($category->posts_count == 0)
                                        <button onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')" 
                                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors duration-200"
                                                title="Xóa chuyên mục">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                        
                                        <form id="delete-form-{{ $category->id }}" method="POST" action="{{ route('categories.destroy', $category) }}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-600 cursor-not-allowed" title="Không thể xóa chuyên mục có bài viết">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-secondary-200 dark:border-gray-700 bg-secondary-50 dark:bg-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-secondary-500 dark:text-gray-300">
                        Hiển thị {{ $categories->firstItem() }}-{{ $categories->lastItem() }} trong {{ $categories->total() }} kết quả
                    </div>
                    <nav class="flex items-center space-x-2">
                        {{-- Previous Page Link --}}
                        @if ($categories->onFirstPage())
                            <span class="px-3 py-1.5 text-xs text-secondary-400 dark:text-gray-500 bg-secondary-100 dark:bg-gray-600 rounded cursor-not-allowed">
                                ← Trước
                            </span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}" class="px-3 py-1.5 text-xs text-secondary-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-200 dark:border-gray-600 rounded hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                ← Trước
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                            @if ($page == $categories->currentPage())
                                <span class="px-3 py-1.5 text-xs bg-primary-600 text-white rounded">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-1.5 text-xs text-secondary-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-200 dark:border-gray-600 rounded hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}" class="px-3 py-1.5 text-xs text-secondary-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-secondary-200 dark:border-gray-600 rounded hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                Tiếp →
                            </a>
                        @else
                            <span class="px-3 py-1.5 text-xs text-secondary-400 dark:text-gray-500 bg-secondary-100 dark:bg-gray-600 rounded cursor-not-allowed">
                                Tiếp →
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-secondary-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <h3 class="text-xl font-heading font-semibold text-secondary-900 dark:text-primary-400-dark mb-2">Chưa có chuyên mục nào</h3>
            <p class="text-secondary-500 dark:text-gray-400 mb-6">Bắt đầu tạo chuyên mục đầu tiên để tổ chức nội dung của bạn</p>
            <a href="{{ route('categories.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tạo chuyên mục đầu tiên
            </a>
        </div>
    @endif
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    let deleteFormId = null;

    const searchInput = document.getElementById('searchInput');
    const categoryRows = document.querySelectorAll('.category-row');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            categoryRows.forEach(row => {
                const name = row.querySelector('.category-name').textContent.toLowerCase();
                const description = row.querySelector('.category-description').textContent.toLowerCase();

                if (name.includes(searchTerm) || description.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    window.confirmDelete = function(categoryId, categoryName) {
        deleteFormId = categoryId;
        showConfirmationModal(
            'Xác nhận xóa',
            `Bạn có chắc chắn muốn xóa chuyên mục "${categoryName}" không?`,
            'Xóa',
            function() {
                if (deleteFormId) {
                    document.getElementById('delete-form-' + deleteFormId).submit();
                }
            }
        );
    };
});
</script>

@endsection
