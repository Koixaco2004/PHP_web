@extends('layouts.app')

@section('title', 'Quản lý chuyên mục')

@section('content')
<!-- Page Header -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 mb-8 animate-fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-heading font-bold text-secondary-900 dark:text-primary-100-dark flex items-center">
                <svg class="w-8 h-8 mr-3 text-primary-600 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Quản lý chuyên mục
            </h1>
            <p class="text-secondary-600 dark:text-gray-300 mt-1">Tạo và quản lý các chuyên mục cho website tin tức</p>
        </div>
        
        <div class="flex items-center space-x-3">
            <!-- Search Input -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Tìm kiếm chuyên mục..." 
                       class="block w-full pl-10 pr-3 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-100-dark dark:placeholder-gray-400 text-sm transition-colors duration-200">
            </div>
            
            <a href="{{ route('categories.create') }}" class="btn-primary flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Thêm chuyên mục
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900-dark rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-secondary-600 dark:text-gray-300">Tổng chuyên mục</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-primary-100-dark">{{ $categories->total() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.1s">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-secondary-600 dark:text-gray-300">Đang hoạt động</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-primary-100-dark">{{ $categories->where('is_active', true)->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.2s">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-accent-100 dark:bg-accent-900 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-secondary-600 dark:text-gray-300">Tổng bài viết</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-primary-100-dark">{{ $categories->sum('posts_count') }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.3s">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-secondary-600 dark:text-gray-300">Chuyên mục trống</p>
                <p class="text-2xl font-bold text-secondary-900 dark:text-primary-100-dark">{{ $categories->where('posts_count', 0)->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 overflow-hidden animate-slide-up" style="animation-delay: 0.4s">
    @if($categories->count() > 0)
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-secondary-200 dark:border-gray-700 bg-secondary-50 dark:bg-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-100-dark">Danh sách chuyên mục</h3>
                <div class="flex items-center space-x-2 text-sm text-secondary-500 dark:text-gray-300">
                    <span>Hiển thị {{ $categories->count() }} / {{ $categories->total() }} chuyên mục</span>
                </div>
            </div>
        </div>
        
        <!-- Table Content -->
        <div class="min-w-fit">
            <table class="w-full min-w-[800px]">
                <thead class="bg-secondary-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-64">Chuyên mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-80">Mô tả</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-24">Bài viết</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-28">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-24">Ngày tạo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-secondary-500 dark:text-gray-300 uppercase tracking-wider w-32">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-secondary-200 dark:divide-gray-700" id="categoriesTable">
                    @foreach($categories as $index => $category)
                        <tr class="category-row hover:bg-secondary-50 dark:hover:bg-gray-700 transition-colors duration-200" style="animation: slideUp 0.3s ease-out {{ $index * 0.1 }}s both">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-secondary-900 dark:text-primary-100-dark category-name">{{ $category->name }}</div>
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
                                   <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->posts_count > 0 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                       {{ $category->posts_count }} BV
                                   </span>
                               </div>
                           </td>
                            <td class="px-6 py-4 whitespace-nowrap w-28">
                                @if($category->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium w-32">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('categories.show', $category) }}" 
                                       class="text-secondary-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200"
                                       title="Xem chuyên mục">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    <a href="{{ route('categories.edit', $category) }}" 
                                       class="text-secondary-600 dark:text-gray-300 hover:text-accent-600 dark:hover:text-accent-400 transition-colors duration-200"
                                       title="Chỉnh sửa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    @if($category->posts_count == 0)
                                        <button onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')" 
                                                class="text-secondary-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-200"
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
                                        <span class="text-secondary-400 dark:text-gray-500" title="Không thể xóa chuyên mục có bài viết">
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
            <h3 class="text-xl font-heading font-semibold text-secondary-900 dark:text-primary-100-dark mb-2">Chưa có chuyên mục nào</h3>
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-black dark:bg-opacity-70 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full animate-slide-up">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-semibold text-secondary-900 dark:text-primary-100-dark">Xác nhận xóa</h3>
                    <p class="text-secondary-500 dark:text-gray-300 text-sm mt-1">Thao tác này không thể hoàn tác</p>
                </div>
            </div>
            
            <p class="text-secondary-700 dark:text-gray-300 mb-6">
                Bạn có chắc chắn muốn xóa chuyên mục <span id="categoryName" class="font-semibold text-secondary-900 dark:text-primary-100-dark"></span> không?
            </p>
            
            <div class="flex space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="btn-secondary flex-1">
                    Hủy
                </button>
                <button type="button" onclick="submitDelete()" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-red-400 dark:focus:ring-offset-gray-800 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Xóa
                </button>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let deleteFormId = null;
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const categoryRows = document.querySelectorAll('.category-row');
    
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
    
    // Delete modal functions
    window.confirmDelete = function(categoryId, categoryName) {
        deleteFormId = categoryId;
        document.getElementById('categoryName').textContent = categoryName;
        document.getElementById('deleteModal').classList.remove('hidden');
    };
    
    window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteFormId = null;
    };
    
    window.submitDelete = function() {
        if (deleteFormId) {
            document.getElementById('delete-form-' + deleteFormId).submit();
        }
    };
    
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
});
</script>

<style>
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
