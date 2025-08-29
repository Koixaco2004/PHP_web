@extends('layouts.app')

@section('title', 'Tạo bài viết mới')

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
    <span class="text-secondary-700 font-medium">Tạo bài viết mới</span>
</nav>

<!-- Page Header -->
<div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 mb-8 animate-slide-up">
    <div class="flex items-center">
        <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
        </div>
        <div>
            <h1 class="text-3xl font-heading font-bold text-secondary-900">Tạo bài viết mới</h1>
            <p class="text-secondary-600 mt-1">Viết và xuất bản nội dung mới cho website</p>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <form method="POST" action="{{ route('posts.store') }}" class="space-y-6" id="postForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="uploaded_images" id="uploadedImages" value="[]">
                <input type="hidden" name="featured_image" id="featuredImageInput" value="">
                
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
                                   value="{{ old('title') }}" 
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

                <!-- Category & Excerpt -->
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
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>📝 Bản nháp</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>🚀 Xuất bản</option>
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
                        <p class="mt-1 text-xs text-secondary-500">Tóm tắt sẽ hiển thị trong danh sách bài viết và mạng xã hội</p>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.5s">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900">Hình ảnh bài viết</h3>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 mb-2">
                            Upload hình ảnh (tối đa 10 ảnh)
                        </label>
                        
                        <!-- Upload Area -->
                        <div class="border-2 border-dashed border-secondary-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors duration-200" id="uploadArea">
                            <input type="file" id="imageInput" multiple accept="image/*" class="hidden">
                            <svg class="w-12 h-12 text-secondary-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-secondary-600 mb-2">Kéo thả ảnh vào đây hoặc</p>
                            <button type="button" class="btn-secondary" onclick="document.getElementById('imageInput').click()">
                                Chọn ảnh
                            </button>
                            <p class="text-xs text-secondary-500 mt-2">Hỗ trợ JPG, PNG, GIF. Tối đa 5MB/ảnh</p>
                        </div>
                        
                        <!-- Preview Area -->
                        <div id="imagePreview" class="mt-4 gap-4" style="display: none;">
                        </div>
                        
                        <!-- Upload Progress -->
                        <div id="uploadProgress" class="mt-4 hidden">
                            <div class="bg-secondary-200 rounded-full h-2">
                                <div id="progressBar" class="bg-primary-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                            <p class="text-sm text-secondary-600 mt-1" id="progressText">Đang upload...</p>
                        </div>
                    </div>
                </div>

                <!-- Content Editor -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.6s">
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
                                      required>{{ old('content') }}</textarea>
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
                <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.7s">
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
                            <button type="submit" name="action" value="publish" class="btn-primary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Xuất bản
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Writing Tips -->
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 animate-slide-up" style="animation-delay: 0.7s">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <h3 class="font-semibold text-primary-800">Mẹo viết bài</h3>
                </div>
                <ul class="space-y-2 text-sm text-primary-700">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Tiêu đề ngắn gọn và thu hút
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Tóm tắt cung cấp thông tin chính
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Sử dụng đoạn văn ngắn, dễ đọc
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Kiểm tra chính tả trước khi xuất bản
                    </li>
                </ul>
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
                        <span class="font-medium" id="wordCount">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary-600">Số ký tự:</span>
                        <span class="font-medium" id="charCount">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary-600">Thời gian đọc:</span>
                        <span class="font-medium" id="readTime">0 phút</span>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="bg-white rounded-xl shadow-sm border border-secondary-200 p-6 animate-slide-up" style="animation-delay: 0.9s">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="font-semibold text-secondary-900">Bài viết gần đây</h3>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="p-2 hover:bg-secondary-50 rounded-lg transition-colors duration-200 cursor-pointer">
                        <div class="font-medium text-secondary-900 line-clamp-2">Hướng dẫn sử dụng Laravel</div>
                        <div class="text-secondary-500">2 ngày trước</div>
                    </div>
                    <div class="p-2 hover:bg-secondary-50 rounded-lg transition-colors duration-200 cursor-pointer">
                        <div class="font-medium text-secondary-900 line-clamp-2">Thiết kế giao diện với Tailwind</div>
                        <div class="text-secondary-500">5 ngày trước</div>
                    </div>
                    <div class="p-2 hover:bg-secondary-50 rounded-lg transition-colors duration-200 cursor-pointer">
                        <div class="font-medium text-secondary-900 line-clamp-2">Tối ưu hóa hiệu suất website</div>
                        <div class="text-secondary-500">1 tuần trước</div>
                    </div>
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
    
    // Image upload functionality
    const imageInput = document.getElementById('imageInput');
    const uploadArea = document.getElementById('uploadArea');
    const imagePreview = document.getElementById('imagePreview');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const uploadedImagesInput = document.getElementById('uploadedImages');
    
    let uploadedImages = [];
    
    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-primary-400', 'bg-primary-50');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-400', 'bg-primary-50');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-primary-400', 'bg-primary-50');
        const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
        handleFiles(files);
    });
    
    // File input change
    imageInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        handleFiles(files);
    });
    
    function handleFiles(files) {
        if (files.length === 0) return;
        
        // Validate file count
        if (uploadedImages.length + files.length > 10) {
            alert('Chỉ có thể upload tối đa 10 ảnh');
            return;
        }
        
        // Validate file size and type
        const validFiles = files.filter(file => {
            if (!file.type.startsWith('image/')) {
                alert(`File ${file.name} không phải là hình ảnh`);
                return false;
            }
            if (file.size > 5 * 1024 * 1024) { // 5MB
                alert(`File ${file.name} quá lớn (tối đa 5MB)`);
                return false;
            }
            return true;
        });
        
        if (validFiles.length === 0) return;
        
        // Show progress
        uploadProgress.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressText.textContent = 'Đang upload...';
        
        // Upload files
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
                alert(`Lỗi upload file ${file.name}`);
            }
        }
        
        // Hide progress after completion
        setTimeout(() => {
            uploadProgress.classList.add('hidden');
        }, 1000);
        
        // Update hidden input
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
                    <span class="w-5 h-5 bg-white border-2 border-gray-300 rounded-full flex items-center justify-center cursor-pointer hover:border-primary-500">
                        <span class="w-2 h-2 bg-primary-500 rounded-full hidden"></span>
                    </span>
                </label>
            </div>
        `;
        
        imagePreview.appendChild(previewItem);
        
        // Set first image as featured by default
        if (uploadedImages.length === 1) {
            const radio = previewItem.querySelector('input[type="radio"]');
            radio.checked = true;
            const indicator = previewItem.querySelector('span span');
            indicator.classList.remove('hidden');
            
            // Update hidden input
            document.getElementById('featuredImageInput').value = imageData.image_url;
        }
    }
    
    // Remove image function
    window.removeImage = function(imageUrl) {
        uploadedImages = uploadedImages.filter(img => img.image_url !== imageUrl);
        uploadedImagesInput.value = JSON.stringify(uploadedImages);
        
        // Remove preview
        const previews = imagePreview.querySelectorAll('img');
        previews.forEach(img => {
            if (img.src === imageUrl) {
                img.closest('.relative').remove();
            }
        });
        
        // Hide preview area if no images
        if (uploadedImages.length === 0) {
            imagePreview.style.display = 'none';
        }
    };
    
    // Featured image selection
    imagePreview.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            // Update visual indicators
            const allIndicators = imagePreview.querySelectorAll('span span');
            allIndicators.forEach(indicator => indicator.classList.add('hidden'));
            
            const selectedIndicator = e.target.closest('label').querySelector('span span');
            selectedIndicator.classList.remove('hidden');
            
            // Update hidden input
            document.getElementById('featuredImageInput').value = e.target.value;
        }
    });
    
    // Form submission handling
    document.getElementById('postForm').addEventListener('submit', function(e) {
        const submitButton = e.submitter;
        if (submitButton && submitButton.name === 'action') {
            document.getElementById('status').value = submitButton.value === 'publish' ? 'published' : 'draft';
        }
    });
    
    // Auto-save functionality (optional)
    let autoSaveTimeout;
    function autoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Implement auto-save logic here
            console.log('Auto-saving draft...');
        }, 30000); // Auto-save every 30 seconds
    }
    
    [titleInput, contentInput, excerptInput].forEach(input => {
        input.addEventListener('input', autoSave);
    });
});
</script>
@endsection
