@extends('layouts.app')

@section('title', 'Chỉnh sửa chuyên mục')

@section('content')
<!-- Breadcrumb -->
<nav class="flex items-center space-x-2 text-sm text-secondary-500 dark:text-gray-400 mb-6">
    <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Trang chủ</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('categories.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400-dark transition-colors duration-200">Quản lý chuyên mục</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-secondary-700 dark:text-gray-300 font-medium">Chỉnh sửa: {{ $category->name }}</span>
</nav>

<!-- Page Header -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark">Chỉnh sửa chuyên mục</h1>
                <p class="text-secondary-600 dark:text-gray-300 mt-1">Cập nhật thông tin cho chuyên mục "{{ $category->name }}"</p>
            </div>
        </div>
        <div class="flex flex-col items-end space-y-2 text-sm">
            <span class="px-3 py-1 bg-{{ $category->is_active ? 'green' : 'gray' }}-100 dark:bg-{{ $category->is_active ? 'green' : 'gray' }}-900 text-{{ $category->is_active ? 'green' : 'gray' }}-800 dark:text-{{ $category->is_active ? 'green' : 'gray' }}-200 rounded-full font-medium">
                {{ $category->is_active ? 'Đang hoạt động' : 'Không hoạt động' }}
            </span>
            <div class="text-right">
                <p class="text-secondary-600 dark:text-gray-300">Ngày tạo: {{ $category->created_at->format('d/m/Y') }}</p>
                <p class="text-secondary-600 dark:text-gray-300">Cập nhật: {{ $category->updated_at->format('d/m/Y') }}</p>
                <p class="text-secondary-600 dark:text-gray-300">Bài viết: {{ $category->posts_count ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div class="w-full">
    <div class="w-full">
        <!-- Main Form -->
        <div class="w-full">
            <form method="POST" action="{{ route('categories.update', $category) }}" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @csrf
                @method('PUT')
                
                <!-- Category Name -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Thông tin cơ bản</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                                Tên chuyên mục <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       class="block w-full px-4 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark transition-colors duration-200 bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 @error('name') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:bg-red-900/20 @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $category->name) }}" 
                                       placeholder="Nhập tên chuyên mục..."
                                       required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-secondary-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-1 text-xs text-secondary-500 dark:text-gray-400">Tên chuyên mục sẽ hiển thị cho người dùng</p>
                        </div>
                    </div>
                </div>

                <!-- Category Description -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Mô tả chuyên mục</h3>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-secondary-700 dark:text-gray-300 mb-2">
                            Mô tả chi tiết
                        </label>
                        <div class="relative">
                            <textarea class="block w-full px-4 py-3 border border-secondary-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark transition-colors duration-200 resize-none bg-white dark:bg-gray-700 dark:text-primary-400-dark dark:placeholder-gray-400 @error('description') !border-red-500 !focus:ring-red-500 !focus:border-red-500 dark:bg-red-900/20 @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Nhập mô tả cho chuyên mục (tùy chọn)...">{{ old('description', $category->description) }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-secondary-500 dark:text-gray-400">Mô tả sẽ giúp người dùng hiểu rõ hơn về nội dung chuyên mục</p>
                    </div>
                </div>

                <!-- Settings -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 lg:col-span-2">
                    <div class="flex items-center mb-4">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Cài đặt</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-secondary-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <h4 class="font-medium text-secondary-900 dark:text-primary-400-dark">Trạng thái hoạt động</h4>
                                <p class="text-sm text-secondary-600 dark:text-gray-300">Chuyên mục sẽ hiển thị công khai trên website</p>
                            </div>
                            <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <label for="is_active" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 dark:bg-gray-600 cursor-pointer"></label>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Form Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-secondary-200 dark:border-gray-700 p-6 lg:col-span-2">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="flex items-center text-sm text-secondary-600 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Các trường có dấu <span class="text-red-500">*</span> là bắt buộc
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('categories.index') }}" class="btn-secondary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Hủy
                            </a>
                            <button type="submit" class="btn-primary flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Cập nhật chuyên mục
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>


<style>
/* Toggle Switch */
.toggle-checkbox:checked {
    @apply right-0 border-primary-500;
    right: 0;
    border-color: #2563eb;
}
.toggle-checkbox:checked + .toggle-label {
    @apply bg-primary-500;
    background-color: #2563eb;
}

.dark .toggle-checkbox:checked {
    @apply border-primary-400-dark;
    border-color: #60a5fa;
}
.dark .toggle-checkbox:checked + .toggle-label {
    @apply bg-primary-400-dark;
    background-color: #60a5fa;
}
</style>
@endsection
