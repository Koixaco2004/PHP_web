@extends('layouts.app')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 dark:text-gray-400 mb-6 animate-fade-in">
    <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('posts.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Quản lý bài viết</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 dark:text-gray-300 font-medium">Chỉnh sửa: {{ Str::limit($post->title, 30) }}</span>
</nav>

<!-- Page Header -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 mb-8 animate-slide-up">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl md:text-3xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark truncate">Chỉnh sửa bài viết</h1>
                <p class="text-sm md:text-base text-secondary-600 dark:text-gray-300 mt-1 truncate">Cập nhật nội dung cho "{{ Str::limit($post->title, 50) }}"</p>
            </div>
        </div>
        <div class="flex items-center space-x-2 text-sm flex-shrink-0">
            <span class="px-3 py-1 bg-{{ $post->status === 'published' ? 'primary' : 'yellow' }}-100 dark:bg-{{ $post->status === 'published' ? 'primary' : 'yellow' }}-900 text-{{ $post->status === 'published' ? 'primary' : 'yellow' }}-800 dark:text-{{ $post->status === 'published' ? 'primary' : 'yellow' }}-200 rounded-full font-medium whitespace-nowrap">
                {{ $post->status === 'published' ? '🚀 Đã xuất bản' : '📝 Bản nháp' }}
            </span>
        </div>
    </div>
</div>

<!-- Rejection Reason Alert -->
@if($post->approval_status === 'rejected' && $post->rejection_reason)
<div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-6 mb-8 rounded-lg animate-slide-up">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <h3 class="text-lg font-semibold text-red-800 dark:text-red-300 mb-2">
                Bài viết đã bị từ chối
            </h3>
            <div class="text-sm text-red-700 dark:text-red-400">
                <p class="font-medium mb-1">Lý do từ chối:</p>
                <p class="bg-white dark:bg-gray-800 p-3 rounded border border-red-200 dark:border-red-800">
                    {{ $post->rejection_reason }}
                </p>
            </div>
            <p class="text-sm text-red-600 dark:text-red-400 mt-3">
                Vui lòng chỉnh sửa bài viết theo yêu cầu và gửi lại để được phê duyệt.
            </p>
        </div>
    </div>
</div>
@endif

<!-- Admin Approval Section (Chỉ hiển thị cho admin khi xem bài pending) -->
@if(Auth::check() && Auth::user()->role === 'admin' && $post->approval_status === 'pending')
<div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 p-6 mb-8 rounded-lg animate-slide-up">
    <div class="flex items-start justify-between">
        <div class="flex items-start flex-1">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-300 mb-2">
                    Bài viết chờ phê duyệt
                </h3>
                <p class="text-sm text-yellow-700 dark:text-yellow-400">
                    Bài viết này đang chờ bạn phê duyệt. Vui lòng xem xét nội dung và quyết định phê duyệt hoặc từ chối.
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-3 ml-4 flex-shrink-0">
            <!-- Approve Button -->
            <form action="{{ route('admin.posts.approve', $post) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200"
                        onclick="return confirm('Bạn có chắc chắn muốn phê duyệt bài viết này?')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Phê duyệt
                </button>
            </form>
            
            <!-- Reject Button -->
            <button type="button"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200"
                    onclick="openRejectModal({{ $post->id }}, '{{ addslashes($post->title) }}')">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Từ chối
            </button>
        </div>
    </div>
</div>
@endif

<div class="max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-6" id="editForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="uploaded_images" id="uploadedImages" value="{{ json_encode($post->images->map(function($img) { return ['image_url' => $img->image_url, 'delete_url' => $img->delete_url, 'alt_text' => $img->alt_text, 'caption' => $img->caption, 'is_featured' => $img->is_featured]; })) }}">
                <input type="hidden" name="deleted_images" id="deletedImages" value="[]">
                
                <!-- Post Title -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.1s">
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
                                   class="block w-full px-4 py-4 text-lg border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark transition-colors duration-200 bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 @error('title') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:!bg-red-900/20 @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $post->title) }}" 
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
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.2s">
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
                            <select class="block w-full px-4 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark transition-colors duration-200 bg-white dark:bg-gray-700 dark:text-primary-400-dark @error('category_id') !border-red-500 !focus:ring-red-500 !focus:border-red-500 @enderror appearance-none" 
                                    id="category_id" name="category_id" required>
                                <option value="">Chọn chuyên mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
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
                
                <!-- Hidden Status Field (will be set by submit buttons) -->
                <input type="hidden" name="status" id="status" value="{{ old('status', $post->status) }}">

                <!-- Excerpt -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.3s">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Tóm tắt bài viết</h3>
                    </div>
                    
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                            Tóm tắt ngắn gọn
                        </label>
                        <div class="relative">
                            <textarea class="block w-full px-4 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark transition-colors duration-200 resize-none bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 @error('excerpt') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:bg-red-900/20 @enderror" 
                                      id="excerpt" 
                                      name="excerpt" 
                                      rows="4" 
                                      placeholder="Viết tóm tắt ngắn gọn để thu hút người đọc...">{{ old('excerpt', $post->excerpt) }}</textarea>
                        </div>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500 dark:text-gray-400">Tóm tắt sẽ hiển thị trong danh sách bài viết và mạng xã hội</p>
                    </div>
                </div>

                <!-- Image Management -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.4s">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Hình ảnh bài viết</h3>
                    </div>

                    <!-- Current Images -->
                    @if($post->images && $post->images->count() > 0)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-secondary-700 dark:text-gray-300 mb-3">Hình ảnh hiện tại</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="currentImages">
                                @foreach($post->images as $image)
                                    <div class="relative group" data-image-id="{{ $image->id }}" data-image-url="{{ $image->image_url }}">
                                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}" class="w-full h-24 object-cover rounded-lg">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center">
                                            <button type="button" onclick="removeExistingImage('{{ $image->image_url }}', this)" class="opacity-0 group-hover:opacity-100 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-all duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                        @if($image->is_featured)
                                            <div class="absolute top-2 left-2">
                                                <span class="bg-primary-600 text-white text-xs px-2 py-1 rounded-full">Ảnh đại diện</span>
                                            </div>
                                        @endif
                                        <label class="absolute top-2 right-2">
                                            <input type="radio" name="existing_featured" value="{{ $image->image_url }}" {{ $image->is_featured ? 'checked' : '' }} class="sr-only">
                                            <span class="block w-6 h-6 bg-white dark:bg-gray-800 rounded-full border-2 border-primary-300 dark:border-primary-400-dark cursor-pointer hover:border-primary-500 dark:hover:border-primary-300-dark transition-colors duration-200">
                                                <span class="block w-3 h-3 bg-primary-600 rounded-full m-0.5 {{ $image->is_featured ? '' : 'hidden' }}"></span>
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Upload New Images -->
                    <div>
                        <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-3">Thêm hình ảnh mới</label>
                        <div class="border-2 border-dashed border-secondary-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-primary-400 dark:hover:border-primary-400-dark transition-colors duration-200 bg-white dark:bg-gray-700" id="imageDropZone">
                            <svg class="mx-auto h-12 w-12 text-secondary-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <div class="text-sm text-secondary-600 dark:text-gray-300">
                                <label for="imageFiles" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-primary-600 dark:text-primary-400-dark hover:text-primary-500 dark:hover:text-primary-300-dark focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500 dark:focus-within:ring-primary-400-dark">
                                    <span>Tải lên hình ảnh</span>
                                    <input id="imageFiles" name="imageFiles[]" type="file" class="sr-only" multiple accept="image/*">
                                </label>
                                <p class="pl-1">hoặc kéo thả vào đây</p>
                            </div>
                            <p class="text-xs text-secondary-500 dark:text-gray-400 mt-2">PNG, JPG, GIF tối đa 5MB mỗi file, tối đa 10 file</p>
                        </div>

                        <!-- Upload Progress -->
                        <div id="uploadProgress" class="hidden mt-4">
                            <div class="bg-secondary-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-primary-600 h-2 rounded-full transition-all duration-300" style="width: 0%" id="progressBar"></div>
                            </div>
                            <p class="text-sm text-secondary-600 dark:text-gray-300 mt-2" id="progressText">Đang tải lên...</p>
                        </div>

                        <!-- New Images Preview -->
                        <div id="newImagePreview" class="mt-4 hidden">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4"></div>
                        </div>
                    </div>
                </div>

                <!-- Content Editor with TinyMCE -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.5s">
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
                                      placeholder="Viết nội dung chi tiết cho bài viết..."
                                      required>{{ old('content', $post->content) }}</textarea>
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

                <!-- Form Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.6s">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="flex items-center text-sm text-secondary-600 dark:text-gray-300">
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
                            
                            @if(Auth::check() && Auth::user()->id === $post->user_id)
                                <!-- Author có thể lưu nháp -->
                                <button type="submit" name="action" value="draft" class="btn-secondary flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    Lưu nháp
                                </button>
                            @endif
                            
                            <button type="submit" name="action" value="update" class="btn-primary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ Auth::check() && Auth::user()->role === 'admin' && Auth::user()->id !== $post->user_id ? 'Phê duyệt & Cập nhật' : 'Cập nhật bài viết' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Post Info -->
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900 dark:to-primary-800 rounded-xl p-6 animate-slide-up" style="animation-delay: 0.7s">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="font-semibold text-primary-800 dark:text-primary-100">Thông tin bài viết</h3>
                </div>
                <div class="space-y-3 text-sm text-primary-700 dark:text-primary-200">
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
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.7s">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <h3 class="font-semibold text-secondary-900 dark:text-primary-400-dark">Thống kê</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-secondary-600 dark:text-gray-300">Số từ:</span>
                        <span class="font-medium" id="wordCount">{{ str_word_count(strip_tags($post->content)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary-600 dark:text-gray-300">Số ký tự:</span>
                        <span class="font-medium" id="charCount">{{ strlen(strip_tags($post->content)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary-600 dark:text-gray-300">Thời gian đọc:</span>
                        <span class="font-medium" id="readTime">{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} phút</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 animate-slide-up" style="animation-delay: 0.9s">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <h3 class="font-semibold text-secondary-900 dark:text-primary-400-dark">Hành động nhanh</h3>
                </div>
                <div class="space-y-2">
                    <a href="{{ route('posts.show', $post) }}" 
                       class="flex items-center w-full p-3 text-sm text-secondary-700 dark:text-gray-300 hover:bg-secondary-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Xem bài viết
                    </a>
                    <a href="{{ route('posts.create') }}" 
                       class="flex items-center w-full p-3 text-sm text-secondary-700 dark:text-gray-300 hover:bg-secondary-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
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

<!-- Image Gallery Modal -->
<div id="imageGalleryModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-black dark:bg-opacity-70 z-50 hidden">
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
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Size Options -->
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Kích thước</label>
                    <select id="imageSize" class="w-full px-3 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark">
                        <option value="small">Nhỏ (300px)</option>
                        <option value="medium" selected>Vừa (500px)</option>
                        <option value="large">Lớn (700px)</option>
                        <option value="full">Toàn bộ (100%)</option>
                    </select>
                </div>
                
                <!-- Alignment Options -->
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Căn lề</label>
                    <select id="imageAlign" class="w-full px-3 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark">
                        <option value="left">Trái</option>
                        <option value="center" selected>Giữa</option>
                        <option value="right">Phải</option>
                    </select>
                </div>
                
                <!-- Caption -->
                <div>
                    <label class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">Chú thích (tùy chọn)</label>
                    <input type="text" id="imageCaption" placeholder="Nhập chú thích..." class="w-full px-3 py-2 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400">
                </div>
            </div>
            
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeImageGallery()" class="px-4 py-2 text-secondary-600 dark:text-gray-300 hover:text-secondary-800 dark:hover:text-primary-100-dark transition-colors">
                    Hủy
                </button>
                <button type="button" onclick="insertSelectedImage()" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 transition-colors">
                    Chèn ảnh
                </button>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
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
    
    document.getElementById('editForm').addEventListener('submit', function(e) {
        const submitButton = e.submitter;
        if (submitButton && submitButton.name === 'action') {
            if (submitButton.value === 'draft') {
                document.getElementById('status').value = 'draft';
            } else if (submitButton.value === 'update') {
                // Giữ nguyên status hiện tại hoặc set là published nếu đang ở draft
                const currentStatus = document.getElementById('status').value;
                if (currentStatus === 'draft') {
                    document.getElementById('status').value = 'published';
                }
            }
        }
    });
    
    let autoSaveTimeout;
    function autoSave() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            console.log('Auto-saving changes...');
        }, 30000);
    }
    
    [titleInput, contentInput, excerptInput].forEach(input => {
        input.addEventListener('input', autoSave);
    });

    let uploadedImages = JSON.parse(document.getElementById('uploadedImages').value || '[]');
    let deletedImages = JSON.parse(document.getElementById('deletedImages').value || '[]');
    const uploadedImagesInput = document.getElementById('uploadedImages');
    const deletedImagesInput = document.getElementById('deletedImages');
    const featuredImageInput = document.getElementById('featuredImageInput');
    const imageDropZone = document.getElementById('imageDropZone');
    const imageFiles = document.getElementById('imageFiles');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const newImagePreview = document.getElementById('newImagePreview');

    imageFiles.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    imageDropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        imageDropZone.classList.add('border-primary-500', 'bg-primary-50');
    });

    imageDropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        imageDropZone.classList.remove('border-primary-500', 'bg-primary-50');
    });

    imageDropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        imageDropZone.classList.remove('border-primary-500', 'bg-primary-50');
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
        if (files.length + uploadedImages.length > 10) {
            alert('Tối đa 10 hình ảnh cho mỗi bài viết');
            return;
        }

        Array.from(files).forEach(file => {
            if (file.size > 5 * 1024 * 1024) {
                alert(`File ${file.name} quá lớn. Tối đa 5MB.`);
                return;
            }
            uploadImage(file);
        });
    }

    function uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        uploadProgress.classList.remove('hidden');
        progressBar.style.width = '0%';
        progressText.textContent = 'Đang tải lên...';

        fetch('/api/upload-temp-image', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                uploadedImages.push(data.data);
                uploadedImagesInput.value = JSON.stringify(uploadedImages);
                addImagePreview(data.data);
                
                if (uploadedImages.length === 1 && !featuredImageInput.value) {
                    featuredImageInput.value = data.data.image_url;
                    updateFeaturedImageDisplay();
                }
            } else {
                alert('Lỗi upload: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            alert('Có lỗi xảy ra khi upload ảnh');
        })
        .finally(() => {
            uploadProgress.classList.add('hidden');
        });
    }

    function addImagePreview(imageData) {
        const previewContainer = newImagePreview.querySelector('.grid');
        const previewItem = document.createElement('div');
        previewItem.className = 'relative group';
        previewItem.innerHTML = `
            <img src="${imageData.image_url}" alt="Preview" class="w-full h-24 object-cover rounded-lg">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-200 rounded-lg flex items-center justify-center">
                <button type="button" onclick="removeNewImage('${imageData.image_url}', this)" class="opacity-0 group-hover:opacity-100 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
            <label class="absolute top-2 right-2">
                <input type="radio" name="new_featured" value="${imageData.image_url}" class="sr-only">
                <span class="block w-6 h-6 bg-white rounded-full border-2 border-primary-300 cursor-pointer hover:border-primary-500 transition-colors duration-200">
                    <span class="block w-3 h-3 bg-primary-600 rounded-full m-0.5 hidden"></span>
                </span>
            </label>
        `;
        
        previewContainer.appendChild(previewItem);
        newImagePreview.classList.remove('hidden');
    }

    window.removeExistingImage = function(imageUrl, button) {
        if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
            deletedImages.push(imageUrl);
            deletedImagesInput.value = JSON.stringify(deletedImages);
            button.closest('[data-image-url]').remove();
            
            if (featuredImageInput.value === imageUrl) {
                featuredImageInput.value = '';
                updateFeaturedImageDisplay();
            }
        }
    };

    window.removeNewImage = function(imageUrl, button) {
        uploadedImages = uploadedImages.filter(img => img.image_url !== imageUrl);
        uploadedImagesInput.value = JSON.stringify(uploadedImages);
        button.closest('.relative').remove();
        
        if (newImagePreview.querySelector('.grid').children.length === 0) {
            newImagePreview.classList.add('hidden');
        }
        
        if (featuredImageInput.value === imageUrl) {
            featuredImageInput.value = '';
            updateFeaturedImageDisplay();
        }
    };

    document.addEventListener('change', function(e) {
        if (e.target.name === 'existing_featured') {
            featuredImageInput.value = e.target.value;
            updateFeaturedImageDisplay();
        }
        if (e.target.name === 'new_featured') {
            featuredImageInput.value = e.target.value;
            updateFeaturedImageDisplay();
        }
    });

    function updateFeaturedImageDisplay() {
        document.querySelectorAll('input[name="existing_featured"]').forEach(radio => {
            const indicator = radio.closest('label').querySelector('span span');
            if (radio.value === featuredImageInput.value) {
                radio.checked = true;
                indicator.classList.remove('hidden');
            } else {
                radio.checked = false;
                indicator.classList.add('hidden');
            }
        });

        document.querySelectorAll('input[name="new_featured"]').forEach(radio => {
            const indicator = radio.closest('label').querySelector('span span');
            if (radio.value === featuredImageInput.value) {
                radio.checked = true;
                indicator.classList.remove('hidden');
            } else {
                radio.checked = false;
                indicator.classList.add('hidden');
            }
        });
    }

    let selectedImageUrl = '';
    let cursorPosition = 0;

    contentInput.addEventListener('selectionchange', function() {
        cursorPosition = contentInput.selectionStart;
    });

    contentInput.addEventListener('click', function() {
        cursorPosition = contentInput.selectionStart;
    });

    contentInput.addEventListener('keyup', function() {
        cursorPosition = contentInput.selectionStart;
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

function openImageGallery() {
    const modal = document.getElementById('imageGalleryModal');
    const grid = document.getElementById('galleryImageGrid');
    const noImagesMsg = document.getElementById('noImagesMessage');
    
    grid.innerHTML = '';
    
    const existingImages = [];
    const deletedImageUrls = JSON.parse(document.getElementById('deletedImages').value || '[]');
    
    document.querySelectorAll('#currentImages [data-image-url]').forEach(item => {
        const imageUrl = item.dataset.imageUrl;
        if (!deletedImageUrls.includes(imageUrl)) {
            existingImages.push({
                url: imageUrl,
                alt: item.querySelector('img').alt || ''
            });
        }
    });
    
    const newImages = JSON.parse(document.getElementById('uploadedImages').value || '[]');
    
    const imageMap = new Map();
    
    existingImages.forEach(img => {
        imageMap.set(img.url, img);
    });
    
    newImages.forEach(img => {
        imageMap.set(img.image_url, {
            url: img.image_url,
            alt: img.alt_text || ''
        });
    });
    
    const allImages = Array.from(imageMap.values());
    
    if (allImages.length === 0) {
        noImagesMsg.classList.remove('hidden');
        grid.classList.add('hidden');
    } else {
        noImagesMsg.classList.add('hidden');
        grid.classList.remove('hidden');
        
        allImages.forEach(image => {
            const imageItem = document.createElement('div');
            imageItem.className = 'relative cursor-pointer group';
            imageItem.innerHTML = `
                <img src="${image.url}" alt="${image.alt}" class="w-full h-24 object-cover rounded-lg border-2 border-transparent group-hover:border-primary-300 transition-colors">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg"></div>
            `;
            
            imageItem.addEventListener('click', () => selectImageForInsertion(image.url));
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
            img.classList.add('border-primary-500');
        } else {
            img.classList.remove('border-primary-500');
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
    <figcaption class="text-sm text-gray-600 mt-2 italic">${caption}</figcaption>
</figure>

`;
    } else {
        imageHtml = `
<img src="${selectedImageUrl}" alt="Image" class="${sizeClass} ${alignClass} rounded-lg shadow-sm my-4">

`;
    }
    
    const contentTextarea = document.getElementById('content');
    const currentPos = contentTextarea.selectionStart || 0;
    const textBefore = contentTextarea.value.substring(0, currentPos);
    const textAfter = contentTextarea.value.substring(currentPos);
    
    contentTextarea.value = textBefore + imageHtml + textAfter;
    
    const newPos = currentPos + imageHtml.length;
    contentTextarea.setSelectionRange(newPos, newPos);
    contentTextarea.focus();
    
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
}

// Reject Modal Functions (for admin)
function openRejectModal(postId, postTitle) {
    document.getElementById('rejectPostId').value = postId;
    document.getElementById('rejectPostTitle').textContent = postTitle;
    document.getElementById('rejectForm').action = `/admin/posts/${postId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.body.style.overflow = '';
    document.getElementById('rejection_reason_type').value = '';
    document.getElementById('custom_rejection_reason').value = '';
    document.getElementById('customReasonField').classList.add('hidden');
}

function toggleCustomReason() {
    const select = document.getElementById('rejection_reason_type');
    const customField = document.getElementById('customReasonField');
    
    if (select.value === 'other') {
        customField.classList.remove('hidden');
    } else {
        customField.classList.add('hidden');
    }
}
</script>

<!-- Reject Modal (for admin) -->
@if(Auth::check() && Auth::user()->role === 'admin')
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-xl bg-white dark:bg-gray-800">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Từ chối bài viết</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="rejectForm" method="POST">
                @csrf
                <input type="hidden" id="rejectPostId" name="post_id">
                
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Bạn đang từ chối bài viết: <span id="rejectPostTitle" class="font-semibold text-gray-900 dark:text-white"></span>
                </p>

                <!-- Reason Dropdown -->
                <div class="mb-4">
                    <label for="rejection_reason_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Lý do từ chối <span class="text-red-500">*</span>
                    </label>
                    <select id="rejection_reason_type" 
                            name="rejection_reason_type" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white dark:bg-gray-700 dark:text-white"
                            onchange="toggleCustomReason()"
                            required>
                        <option value="">Chọn lý do</option>
                        <option value="Nội dung không phù hợp">Nội dung không phù hợp</option>
                        <option value="Vi phạm quy định">Vi phạm quy định</option>
                        <option value="Thông tin sai lệch">Thông tin sai lệch</option>
                        <option value="Chất lượng kém">Chất lượng kém</option>
                        <option value="Trùng lặp nội dung">Trùng lặp nội dung</option>
                        <option value="other">Lý do khác...</option>
                    </select>
                </div>

                <!-- Custom Reason Field -->
                <div id="customReasonField" class="mb-4 hidden">
                    <label for="custom_rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nhập lý do cụ thể
                    </label>
                    <textarea id="custom_rejection_reason" 
                              name="custom_rejection_reason" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white dark:bg-gray-700 dark:text-white"
                              placeholder="Nhập lý do từ chối chi tiết..."></textarea>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 mt-6">
                    <button type="button" 
                            onclick="closeRejectModal()" 
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Hủy
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Từ chối bài viết
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Include TinyMCE Configuration -->
@include('posts.partials.tinymce-config')
@endsection
