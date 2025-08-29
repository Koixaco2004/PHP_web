@extends('layouts.app')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 mb-6 animate-fade-in">
    <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('posts.index') }}" class="hover:text-primary-600 transition-colors duration-200">Quản lý bài viết</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 font-medium">Chỉnh sửa: {{ Str::limit($post->title, 30) }}</span>
</nav>

<!-- Page Header -->
<div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 mb-8 animate-slide-up">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-heading font-bold text-secondary-900">Chỉnh sửa bài viết</h1>
                <p class="text-secondary-600 mt-1">Cập nhật nội dung cho "{{ $post->title }}"</p>
            </div>
        </div>
        <div class="hidden md:flex items-center space-x-2 text-sm">
            <span class="px-3 py-1 bg-{{ $post->status === 'published' ? 'green' : 'yellow' }}-100 text-{{ $post->status === 'published' ? 'green' : 'yellow' }}-800 rounded-full font-medium">
                {{ $post->status === 'published' ? '🚀 Đã xuất bản' : '📝 Bản nháp' }}
            </span>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-6" id="editForm">
                @csrf
                @method('PUT')
                
                <!-- Post Title -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.1s">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900">Tiêu đề bài viết</h3>
                    </div>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-secondary-700 mb-2">
                            Tiêu đề <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   class="block w-full px-4 py-4 text-lg border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('title') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $post->title) }}" 
                                   placeholder="Nhập tiêu đề hấp dẫn cho bài viết..."
                                   required>
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500">Tiêu đề sẽ hiển thị trong danh sách bài viết và kết quả tìm kiếm</p>
                    </div>
                </div>

                <!-- Category & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category Selection -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.2s">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-secondary-900">Chuyên mục</h3>
                        </div>
                        
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-secondary-700 mb-2">
                                Chọn chuyên mục <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select class="block w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('category_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror appearance-none bg-white" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Chọn chuyên mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.3s">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-secondary-900">Trạng thái</h3>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-secondary-700 mb-2">
                                Trạng thái xuất bản <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select class="block w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 @error('status') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror appearance-none bg-white" 
                                        id="status" name="status" required>
                                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>📝 Bản nháp</option>
                                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>🚀 Xuất bản</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.4s">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900">Tóm tắt bài viết</h3>
                    </div>
                    
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-secondary-700 mb-2">
                            Tóm tắt ngắn gọn
                        </label>
                        <div class="relative">
                            <textarea class="block w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 resize-none @error('excerpt') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" 
                                      id="excerpt" 
                                      name="excerpt" 
                                      rows="4" 
                                      placeholder="Viết tóm tắt ngắn gọn để thu hút người đọc...">{{ old('excerpt', $post->excerpt) }}</textarea>
                        </div>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500">Tóm tắt sẽ hiển thị trong danh sách bài viết và mạng xã hội</p>
                    </div>
                </div>

                <!-- Content Editor -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.5s">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900">Nội dung bài viết</h3>
                    </div>
                    
                    <div>
                        <label for="content" class="block text-sm font-medium text-secondary-700 mb-2">
                            Nội dung chi tiết <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea class="block w-full px-4 py-4 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200 resize-none @error('content') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror" 
                                      id="content" 
                                      name="content" 
                                      rows="15" 
                                      placeholder="Viết nội dung chi tiết cho bài viết..."
                                      required>{{ old('content', $post->content) }}</textarea>
                        </div>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500">Hỗ trợ Markdown và HTML. Sử dụng các thẻ để định dạng nội dung</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.6s">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="flex items-center text-sm text-secondary-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Các trường có dấu <span class="text-red-500">*</span> là bắt buộc
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('posts.index') }}" class="btn-secondary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Hủy
                            </a>
                            <button type="submit" name="action" value="draft" class="btn-secondary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Lưu nháp
                            </button>
                            <button type="submit" name="action" value="update" class="btn-primary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Cập nhật bài viết
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Post Info -->
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 animate-slide-up" style="animation-delay: 0.7s">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="font-semibold text-primary-800">Thông tin bài viết</h3>
                </div>
                <div class="space-y-3 text-sm text-primary-700">
                    <div class="flex justify-between">
                        <span>Ngày tạo:</span>
                        <span class="font-medium">{{ $post->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Cập nhật cuối:</span>
                        <span class="font-medium">{{ $post->updated_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tác giả:</span>
                        <span class="font-medium">{{ $post->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Lượt xem:</span>
                        <span class="font-medium">{{ $post->views ?? 0 }} lượt</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Bình luận:</span>
                        <span class="font-medium">{{ $post->comments_count ?? 0 }} bình luận</span>
                    </div>
                </div>
            </div>

            <!-- Writing Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.8s">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <h3 class="font-semibold text-secondary-900">Thống kê</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-secondary-600">Số từ:</span>
                        <span class="font-medium" id="wordCount">{{ str_word_count(strip_tags($post->content)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary-600">Số ký tự:</span>
                        <span class="font-medium" id="charCount">{{ strlen(strip_tags($post->content)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary-600">Thời gian đọc:</span>
                        <span class="font-medium" id="readTime">{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} phút</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.9s">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <h3 class="font-semibold text-secondary-900">Hành động nhanh</h3>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('posts.show', $post) }}" 
                       class="flex items-center w-full p-3 text-sm text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Xem bài viết
                    </a>
                    <a href="{{ route('posts.create') }}" 
                       class="flex items-center w-full p-3 text-sm text-secondary-700 hover:bg-secondary-50 rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tạo bài viết mới
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Writing statistics
    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    const excerptInput = document.getElementById('excerpt');
    const wordCount = document.getElementById('wordCount');
    const charCount = document.getElementById('charCount');
    const readTime = document.getElementById('readTime');
    
    function updateStats() {
        const content = contentInput.value;
        const words = content.trim() ? content.trim().split(/\s+/).length : 0;
        const chars = content.length;
        const readingTime = Math.max(1, Math.ceil(words / 200)); // Assume 200 words per minute
        
        wordCount.textContent = words;
        charCount.textContent = chars;
        readTime.textContent = readingTime + ' phút';
    }
    
    contentInput.addEventListener('input', updateStats);
    updateStats();
    
    // Form submission handling
    document.getElementById('editForm').addEventListener('submit', function(e) {
        const submitButton = e.submitter;
        if (submitButton && submitButton.name === 'action') {
            if (submitButton.value === 'draft') {
                document.getElementById('status').value = 'draft';
            }
        }
    });
    
    // Auto-save functionality
    let autoSaveTimeout;
    function autoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            console.log('Auto-saving changes...');
        }, 30000); // Auto-save every 30 seconds
    }
    
    [titleInput, contentInput, excerptInput].forEach(input => {
        input.addEventListener('input', autoSave);
    });
});
</script>
@endsection
