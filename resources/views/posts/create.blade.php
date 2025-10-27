@extends('layouts.app')

@section('title', 'Tạo bài viết mới')

@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 dark:text-gray-400 mb-6">
    <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ url()->previous() ?: route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Quản lý bài viết</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 dark:text-gray-300 font-medium">Tạo bài viết mới</span>
</nav>

<!-- Page Header -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 mb-8">
    <div class="flex items-center">
        <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark">Tạo bài viết mới</h1>
            <p class="text-secondary-600 dark:text-gray-300 mt-1">Viết và đăng nội dung mới cho website</p>
        </div>
    </div>
</div>

<div class="w-full">
    <form method="POST" action="{{ route('posts.store') }}" class="space-y-6" id="postForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="uploaded_images" id="uploadedImages" value="[]">
        <input type="hidden" name="featured_image" id="featuredImageInput" value="">

        <!-- Metadata Section: 2 columns -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Post Title -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Tiêu đề bài viết</h3>
                    </div>

                    <div>
                        <label for="title" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                            Tiêu đề <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   class="block w-full px-4 py-4 text-lg border bg-white dark:bg-gray-700 border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark dark:text-primary-400-dark dark:placeholder-gray-400 transition-colors duration-200 @error('title') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:!bg-red-900/20 @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   placeholder="Nhập tiêu đề hấp dẫn cho bài viết..."
                                   required>
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500 dark:text-gray-400">Tiêu đề sẽ hiển thị trong danh sách bài viết và kết quả tìm kiếm</p>
                    </div>
                </div>

                <!-- Category Selection -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Chuyên mục</h3>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                            Chọn chuyên mục <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select class="block w-full px-4 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark transition-colors duration-200 @error('category_id') !border-red-500 !focus:ring-red-500 !focus:border-red-500 @enderror appearance-none"
                                    id="category_id" name="category_id" required>
                                <option value="">Chọn chuyên mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500 dark:text-gray-400">Chọn chuyên mục phù hợp để phân loại bài viết</p>
                    </div>
                </div>
        </div>

        <!-- Excerpt and Stats Section: 2 columns -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Excerpt: 2 cols -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Tóm tắt bài viết</h3>
                    </div>
                    
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                            Tóm tắt ngắn gọn
                        </label>
                        <div class="relative">
                            <textarea class="block w-full px-4 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-primary-500 dark:focus:border-primary-400-dark transition-colors duration-200 resize-none bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 @error('excerpt') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:bg-red-900/20 @enderror" 
                                      id="excerpt" 
                                      name="excerpt" 
                                      rows="4" 
                                      placeholder="Viết tóm tắt ngắn gọn để thu hút người đọc...">{{ old('excerpt') }}</textarea>
                        </div>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500 dark:text-gray-400">Tóm tắt sẽ hiển thị trong danh sách bài viết và mạng xã hội</p>
                    </div>
                </div>

                <!-- Writing Stats: 1 col -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <h3 class="font-semibold text-secondary-900 dark:text-primary-400-dark">Thống kê viết</h3>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-secondary-600 dark:text-gray-300">Số từ:</span>
                            <span class="font-medium" id="wordCount">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-secondary-600 dark:text-gray-300">Số ký tự:</span>
                            <span class="font-medium" id="charCount">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-secondary-600 dark:text-gray-300">Thời gian đọc:</span>
                            <span class="font-medium" id="readTime">0 phút</span>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Image Upload Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Hình ảnh bài viết</h3>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                            Upload hình ảnh (tối đa 10 ảnh)
                        </label>
                        
                        <!-- Upload Area -->
                        <div class="border-2 border-dashed border-secondary-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-primary-400 dark:hover:border-primary-400-dark transition-colors duration-200 bg-white dark:bg-gray-700" id="uploadArea">
                            <input type="file" id="imageInput" multiple accept="image/*" class="hidden">
                            <svg class="w-12 h-12 text-secondary-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-secondary-600 dark:text-gray-300 mb-2">Kéo thả ảnh vào đây hoặc</p>
                            <button type="button" class="btn-secondary" onclick="document.getElementById('imageInput').click()">
                                Chọn ảnh
                            </button>
                            <p class="text-xs text-secondary-500 dark:text-gray-400 mt-2">Hỗ trợ JPG, PNG, GIF. Tối đa 5MB/ảnh</p>
                        </div>
                        
                        <!-- Preview Area -->
                        <div id="imagePreview" class="mt-4 gap-4" style="display: none;">
                        </div>
                        
                        <!-- Upload Progress -->
                        <div id="uploadProgress" class="mt-4 hidden">
                            <div class="bg-secondary-200 dark:bg-gray-700 rounded-full h-2">
                                <div id="progressBar" class="bg-primary-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p class="text-sm text-secondary-600 dark:text-gray-300 mt-1" id="progressText">Đang upload...</p>
                        </div>
                    </div>
                </div>

        <!-- Content Editor with TinyMCE -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Nội dung bài viết</h3>
                    </div>
                    
                    <div>
                        <label for="content" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                            Nội dung chi tiết <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="relative">
                            <textarea class="block w-full px-4 py-4 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark transition-colors duration-200 bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 @error('content') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:bg-red-900/20 @enderror"
                                      id="content"
                                      name="content"
                                      placeholder="Viết nội dung chi tiết cho bài viết...">{{ old('content') }}</textarea>
                        </div>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500 dark:text-gray-400">Sử dụng trình soạn thảo WYSIWYG để định dạng nội dung một cách trực quan</p>
                    </div>
                </div>

        <!-- Submit Actions Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center text-sm text-secondary-600 dark:text-gray-400">
                    <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Các trường có dấu <span class="text-red-500">*</span> là bắt buộc
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" onclick="goBack()" class="btn-secondary flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Hủy
                    </button>
                    <button type="submit" class="btn-primary flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Đăng bài
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Image Gallery Modal -->
<div id="imageGalleryModal" class="fixed inset-0 z-50 hidden" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="flex items-center justify-center p-4 min-h-full">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b border-secondary-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Chọn hình ảnh để chèn</h3>
                <button type="button" onclick="closeImageGallery()" class="text-secondary-400 dark:text-gray-400 hover:text-secondary-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div id="galleryImageGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Images will be populated here -->
                </div>
                <div id="noImagesMessage" class="text-center py-8 text-secondary-500 dark:text-gray-400 hidden">
                    <svg class="w-12 h-12 mx-auto mb-4 text-secondary-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z"/>
                    </svg>
                    <p>Chưa có hình ảnh nào. Hãy upload ảnh trước khi chèn vào nội dung.</p>
                </div>
            </div>
            
            <div id="imageOptionsPanel" class="hidden border-t border-secondary-200 dark:border-gray-700 p-6 bg-secondary-50 dark:bg-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-medium text-secondary-900 dark:text-primary-400-dark">Tùy chọn hiển thị</h4>
                    <img id="selectedImagePreview" class="w-16 h-16 object-cover rounded-lg" src="" alt="">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Kích thước</label>
                        <select id="imageSize" class="block w-full px-3 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 dark:text-primary-400-dark">
                            <option value="small">Nhỏ</option>
                            <option value="medium" selected>Trung bình</option>
                            <option value="large">Lớn</option>
                            <option value="full">Toàn bộ</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Căn chỉnh</label>
                        <select id="imageAlign" class="block w-full px-3 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 dark:text-primary-400-dark">
                            <option value="left">Trái</option>
                            <option value="center" selected>Giữa</option>
                            <option value="right">Phải</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Chú thích (tùy chọn)</label>
                    <input type="text" id="imageCaption" class="block w-full px-3 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 dark:text-primary-400-dark" placeholder="Nhập chú thích cho ảnh...">
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeImageGallery()" class="btn-secondary">Hủy</button>
                    <button type="button" onclick="insertSelectedImage()" class="btn-primary">Chèn ảnh</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function goBack() {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        // Fallback: redirect to home or appropriate page based on user role
        @if(Auth::check() && Auth::user()->role === 'admin')
            window.location.href = '{{ route('admin.dashboard') }}';
        @else
            window.location.href = '{{ route('home') }}';
        @endif
    }
}

document.addEventListener('DOMContentLoaded', function() {
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
        const readingTime = Math.max(1, Math.ceil(words / 200));
        
        wordCount.textContent = words;
        charCount.textContent = chars;
        readTime.textContent = readingTime + ' phút';
    }
    
    contentInput.addEventListener('input', updateStats);
    updateStats();
    
    const imageInput = document.getElementById('imageInput');
    const uploadArea = document.getElementById('uploadArea');
    const imagePreview = document.getElementById('imagePreview');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const uploadedImagesInput = document.getElementById('uploadedImages');
    
    let uploadedImages = [];
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-primary-400', 'dark:border-primary-400-dark', 'bg-primary-50', 'dark:bg-primary-900');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-400', 'dark:border-primary-400-dark', 'bg-primary-50', 'dark:bg-primary-900');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-400', 'dark:border-primary-400-dark', 'bg-primary-50', 'dark:bg-primary-900');
        const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
        handleFiles(files);
    });
    
    imageInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        handleFiles(files);
    });
    
    function handleFiles(files) {
        if (files.length === 0) return;
        
        if (uploadedImages.length + files.length > 10) {
            if (typeof showToast === 'function') {
                showToast('Chỉ có thể upload tối đa 10 ảnh', 'error');
            } else {
                alert('Chỉ có thể upload tối đa 10 ảnh');
            }
            return;
        }
        
        const validFiles = files.filter(file => {
            if (!file.type.startsWith('image/')) {
                if (typeof showToast === 'function') {
                    showToast(`File ${file.name} không phải là hình ảnh`, 'error');
                } else {
                    alert(`File ${file.name} không phải là hình ảnh`);
                }
                return false;
            }
            if (file.size > 5 * 1024 * 1024) {
                if (typeof showToast === 'function') {
                    showToast(`File ${file.name} quá lớn (tối đa 5MB)`, 'error');
                } else {
                    alert(`File ${file.name} quá lớn (tối đa 5MB)`);
                }
                return false;
            }
            return true;
        });
        
        if (validFiles.length === 0) return;
        
        uploadProgress.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressText.textContent = 'Đang upload...';
        
        uploadFiles(validFiles);
    }
    
    async function uploadFiles(files) {
        const totalFiles = files.length;
        let completedFiles = 0;
        
        for (const file of files) {
            try {
                const formData = new FormData();
                formData.append('image', file);
                
                const response = await fetch('/api/upload-temp-image', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        uploadedImages.push(result.data);
                        addImagePreview(result.data, file);
                    }
                }
                
                completedFiles++;
                const progress = (completedFiles / totalFiles) * 100;
                progressBar.style.width = progress + '%';
                progressText.textContent = `Đã upload ${completedFiles}/${totalFiles} ảnh`;
                
            } catch (error) {
                console.error('Upload error:', error);
                if (typeof showToast === 'function') {
                    showToast(`Lỗi upload file ${file.name}`, 'error');
                } else {
                    alert(`Lỗi upload file ${file.name}`);
                }
            }
        }
        
        setTimeout(() => {
            uploadProgress.classList.add('hidden');
        }, 1000);
        
        uploadedImagesInput.value = JSON.stringify(uploadedImages);
    }
    
    function addImagePreview(imageData, file) {
        if (uploadedImages.length === 1) {
            imagePreview.style.display = 'grid';
            imagePreview.className = 'mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4';
        }
        
        const previewItem = document.createElement('div');
        previewItem.className = 'relative group';
        previewItem.innerHTML = `
            <img src="${imageData.image_url}" alt="Preview" class="w-full h-24 object-cover rounded-lg">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-200 rounded-lg flex items-center justify-center">
                <button type="button" class="opacity-0 group-hover:opacity-100 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition-all duration-200" onclick="removeImage('${imageData.image_url}')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="absolute top-1 left-1">
                <label class="flex items-center">
                    <input type="radio" name="featured_image" value="${imageData.image_url}" class="sr-only">
                    <span class="w-5 h-5 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-full flex items-center justify-center cursor-pointer hover:border-primary-500 dark:hover:border-primary-400-dark">
                        <span class="w-2 h-2 bg-primary-500 rounded-full hidden"></span>
                    </span>
                </label>
            </div>
        `;
        
        imagePreview.appendChild(previewItem);
        
        if (uploadedImages.length === 1) {
            const radio = previewItem.querySelector('input[type="radio"]');
            radio.checked = true;
            const indicator = previewItem.querySelector('span span');
            indicator.classList.remove('hidden');
            
            document.getElementById('featuredImageInput').value = imageData.image_url;
        }
    }
    
    window.removeImage = function(imageUrl) {
        const uploadedImagesInput = document.getElementById('uploadedImages');
        const imagePreview = document.getElementById('imagePreview');
        
        // Parse and update images array
        let currentImages = JSON.parse(uploadedImagesInput.value || '[]');
        currentImages = currentImages.filter(img => img.image_url !== imageUrl);
        uploadedImagesInput.value = JSON.stringify(currentImages);
        
        // Remove preview element
        const previews = imagePreview.querySelectorAll('img');
        previews.forEach(img => {
            if (img.src === imageUrl) {
                img.closest('.relative').remove();
            }
        });
        
        // Hide preview grid if no images left
        if (currentImages.length === 0) {
            imagePreview.style.display = 'none';
        }
    };
    
    // Function để thêm ảnh từ TinyMCE vào gallery
    window.addImageToGallery = function(imageUrl, deleteUrl, filename) {
        // Lấy elements
        const uploadedImagesInput = document.getElementById('uploadedImages');
        const imagePreview = document.getElementById('imagePreview');
        
        // Parse current images
        let currentImages = JSON.parse(uploadedImagesInput.value || '[]');
        
        // Kiểm tra xem ảnh đã tồn tại chưa
        const existingImage = currentImages.find(img => img.image_url === imageUrl);
        if (existingImage) {
            console.log('⚠️ Ảnh đã tồn tại trong gallery:', imageUrl);
            return; // Ảnh đã có trong gallery
        }
        
        // Thêm ảnh vào array
        const imageData = {
            image_url: imageUrl,
            delete_url: deleteUrl || null,
            alt_text: filename || ''
        };
        
        currentImages.push(imageData);
        uploadedImagesInput.value = JSON.stringify(currentImages);
        
        // Hiển thị grid nếu đây là ảnh đầu tiên
        if (currentImages.length === 1) {
            imagePreview.style.display = 'grid';
            imagePreview.className = 'mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4';
        }
        
        // Tạo preview item
        const previewItem = document.createElement('div');
        previewItem.className = 'relative group';
        previewItem.innerHTML = `
            <img src="${imageUrl}" alt="${filename || 'Preview'}" class="w-full h-24 object-cover rounded-lg">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-200 rounded-lg flex items-center justify-center">
                <button type="button" class="opacity-0 group-hover:opacity-100 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition-all duration-200" onclick="removeImage('${imageUrl}')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="absolute top-1 left-1">
                <label class="flex items-center">
                    <input type="radio" name="featured_image" value="${imageUrl}" class="sr-only">
                    <span class="w-5 h-5 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-full flex items-center justify-center cursor-pointer hover:border-primary-500 dark:hover:border-primary-400-dark">
                        <span class="w-2 h-2 bg-primary-500 rounded-full hidden"></span>
                    </span>
                </label>
            </div>
        `;
        
        imagePreview.appendChild(previewItem);
        
        // Nếu đây là ảnh đầu tiên, set làm featured
        if (currentImages.length === 1) {
            const radio = previewItem.querySelector('input[type="radio"]');
            radio.checked = true;
            const indicator = previewItem.querySelector('span span');
            indicator.classList.remove('hidden');
            document.getElementById('featuredImageInput').value = imageUrl;
        }
        
        console.log('✅ Đã thêm ảnh vào gallery:', imageUrl);
    };
    
    imagePreview.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            const allIndicators = imagePreview.querySelectorAll('span span');
            allIndicators.forEach(indicator => indicator.classList.add('hidden'));
            
            const selectedIndicator = e.target.closest('label').querySelector('span span');
            selectedIndicator.classList.remove('hidden');
            
            document.getElementById('featuredImageInput').value = e.target.value;
        }
    });
    
    document.getElementById('postForm').addEventListener('submit', function(e) {
        // Validate TinyMCE content
        if (tinymce && tinymce.get('content')) {
            tinymce.get('content').save();
            const content = tinymce.get('content').getContent({format: 'text'}).trim();
            if (!content) {
                e.preventDefault();
                if (typeof showToast === 'function') {
                    showToast('Vui lòng nhập nội dung bài viết', 'error');
                } else {
                    alert('Vui lòng nhập nội dung bài viết');
                }
                tinymce.get('content').focus();
                return;
            }
        }
    });
    
    let autoSaveTimeout;
    function autoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            console.log('Auto-saving...');
        }, 30000);
    }
    
    [titleInput, contentInput, excerptInput].forEach(input => {
        input.addEventListener('input', autoSave);
    });
});

function formatText(type) {
    const contentTextarea = document.getElementById('content');
    const start = contentTextarea.selectionStart;
    const end = contentTextarea.selectionEnd;
    const selectedText = contentTextarea.value.substring(start, end);
    let replacement = '';

    switch(type) {
        case 'bold':
            replacement = selectedText ? `**${selectedText}**` : '**text**';
            break;
        case 'italic':
            replacement = selectedText ? `*${selectedText}*` : '*text*';
            break;
        case 'underline':
            replacement = selectedText ? `<u>${selectedText}</u>` : '<u>text</u>';
            break;
        case 'h1':
            replacement = selectedText ? `# ${selectedText}` : '# Heading 1';
            break;
        case 'h2':
            replacement = selectedText ? `## ${selectedText}` : '## Heading 2';
            break;
        case 'h3':
            replacement = selectedText ? `### ${selectedText}` : '### Heading 3';
            break;
        case 'link':
            const url = prompt('Nhập URL:');
            if (url) {
                replacement = selectedText ? `[${selectedText}](${url})` : `[link text](${url})`;
            } else {
                return;
            }
            break;
        case 'ul':
            replacement = selectedText ? `- ${selectedText}` : '- List item';
            break;
        case 'ol':
            replacement = selectedText ? `1. ${selectedText}` : '1. List item';
            break;
    }

    const newValue = contentTextarea.value.substring(0, start) + replacement + contentTextarea.value.substring(end);
    contentTextarea.value = newValue;
    
    const newCursorPos = start + replacement.length;
    contentTextarea.setSelectionRange(newCursorPos, newCursorPos);
    contentTextarea.focus();
    
    const event = new Event('input', { bubbles: true });
    contentTextarea.dispatchEvent(event);
}

let selectedImageUrl = '';

function openImageGallery() {
    const modal = document.getElementById('imageGalleryModal');
    const grid = document.getElementById('galleryImageGrid');
    const noImagesMsg = document.getElementById('noImagesMessage');
    
    grid.innerHTML = '';
    
    const uploadedImagesInput = document.getElementById('uploadedImages');
    const uploadedImages = JSON.parse(uploadedImagesInput.value || '[]');
    
    if (uploadedImages.length === 0) {
        noImagesMsg.classList.remove('hidden');
        grid.classList.add('hidden');
    } else {
        noImagesMsg.classList.add('hidden');
        grid.classList.remove('hidden');
        
        uploadedImages.forEach(image => {
            const imageItem = document.createElement('div');
            imageItem.className = 'relative cursor-pointer group';
            imageItem.innerHTML = `
                <img src="${image.image_url}" alt="${image.alt_text || ''}" class="w-full h-24 object-cover rounded-lg border-2 border-transparent group-hover:border-primary-300 dark:group-hover:border-primary-400-dark transition-colors">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg"></div>
            `;
            
            imageItem.addEventListener('click', () => selectImageForInsertion(image.image_url));
            grid.appendChild(imageItem);
        });
    }
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function selectImageForInsertion(imageUrl) {
    selectedImageUrl = imageUrl;
    
    document.querySelectorAll('#galleryImageGrid .relative').forEach(item => {
        const img = item.querySelector('img');
        if (img.src === imageUrl) {
            img.classList.add('border-primary-500', 'dark:border-primary-400-dark');
            img.classList.remove('border-transparent');
        } else {
            img.classList.remove('border-primary-500', 'dark:border-primary-400-dark');
            img.classList.add('border-transparent');
        }
    });
    
    const optionsPanel = document.getElementById('imageOptionsPanel');
    const preview = document.getElementById('selectedImagePreview');
    
    preview.src = imageUrl;
    optionsPanel.classList.remove('hidden');
}

function insertSelectedImage() {
    if (!selectedImageUrl) return;
    
    const size = document.getElementById('imageSize').value;
    const align = document.getElementById('imageAlign').value;
    const caption = document.getElementById('imageCaption').value;
    
    let imageHtml = '';
    let sizeClass = '';
    
    switch(size) {
        case 'small': sizeClass = 'max-w-xs'; break;
        case 'medium': sizeClass = 'max-w-md'; break;
        case 'large': sizeClass = 'max-w-2xl'; break;
        case 'full': sizeClass = 'w-full'; break;
    }
    
    let alignClass = '';
    switch(align) {
        case 'left': alignClass = 'float-left mr-4 mb-4'; break;
        case 'center': alignClass = 'mx-auto block'; break;
        case 'right': alignClass = 'float-right ml-4 mb-4'; break;
    }
    
    if (caption) {
        imageHtml = `
<figure class="${align === 'center' ? 'text-center' : ''} my-4">
    <img src="${selectedImageUrl}" alt="${caption}" class="${sizeClass} ${alignClass} rounded-lg shadow-sm">
    <figcaption class="text-sm text-gray-600 dark:text-gray-400 mt-2 italic">${caption}</figcaption>
</figure>

`;
    } else {
        imageHtml = `
<img src="${selectedImageUrl}" alt="Image" class="${sizeClass} ${alignClass} rounded-lg shadow-sm my-4">

`;
    }
    
    if (tinymce && tinymce.get('content')) {
        tinymce.get('content').insertContent(imageHtml);
    } else {
        const contentTextarea = document.getElementById('content');
        const currentPos = contentTextarea.selectionStart || 0;
        const textBefore = contentTextarea.value.substring(0, currentPos);
        const textAfter = contentTextarea.value.substring(currentPos);
        
        contentTextarea.value = textBefore + imageHtml + textAfter;
        
        const newPos = currentPos + imageHtml.length;
        contentTextarea.setSelectionRange(newPos, newPos);
        contentTextarea.focus();
        
        const event = new Event('input', { bubbles: true });
        contentTextarea.dispatchEvent(event);
    }
    
    closeImageGallery();
}

function closeImageGallery() {
    const modal = document.getElementById('imageGalleryModal');
    const optionsPanel = document.getElementById('imageOptionsPanel');
    
    modal.classList.add('hidden');
    optionsPanel.classList.add('hidden');
    document.body.style.overflow = '';
    
    document.getElementById('imageSize').value = 'medium';
    document.getElementById('imageAlign').value = 'center';
    document.getElementById('imageCaption').value = '';
    selectedImageUrl = '';
    
    document.querySelectorAll('#galleryImageGrid .relative img').forEach(img => {
        img.classList.remove('border-primary-500', 'dark:border-primary-400-dark');
        img.classList.add('border-transparent');
    });
}
</script>

<!-- Include TinyMCE Configuration -->
@include('posts.partials.tinymce-config')
@endsection
