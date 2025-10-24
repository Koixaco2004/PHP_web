@extends('layouts.app')

@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-primary-100-dark">Chỉnh sửa hồ sơ</h1>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">Cập nhật thông tin cá nhân của bạn</p>
                </div>
                <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Quay lại
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-primary-50 dark:bg-primary-900-dark dark:border-primary-700-dark dark:text-primary-100-dark px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Avatar Section -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-primary-100-dark mb-4">Ảnh đại diện</h2>
                    
                    <div class="flex flex-col items-center">
                        <div class="relative">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-4 border-white dark:border-gray-800 shadow-lg">
                                @if($user->avatar)
                                    <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div id="avatar-preview" class="w-full h-full flex items-center justify-center bg-gray-300 dark:bg-gray-600">
                                        <svg class="w-16 h-16 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="mt-4 w-full">
                            @csrf
                            <div class="flex flex-col space-y-3">
                                <input type="file" name="avatar" id="avatar-input" accept="image/*" class="hidden">
                                <button type="button" onclick="document.getElementById('avatar-input').click()"
                                        class="w-full px-4 py-2 bg-primary-600 dark:bg-primary-500-dark text-white text-sm font-medium rounded-lg hover:bg-primary-700 dark:hover:bg-primary-400-dark transition duration-150">
                                    Chọn ảnh mới
                                </button>
                                <button type="submit" id="upload-btn" class="w-full px-4 py-2 bg-primary-600 dark:bg-primary-500-dark text-white text-sm font-medium rounded-lg hover:bg-primary-700 dark:hover:bg-primary-400-dark transition duration-150 hidden">
                                    Tải lên
                                </button>
                            </div>
                            @error('avatar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-primary-100-dark">Thông tin cá nhân</h2>
                    </div>
                    
                    <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name & Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Họ và tên</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required disabled
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Email không thể thay đổi</p>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bio -->
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tiểu sử</label>
                            <textarea name="bio" id="bio" rows="4" placeholder="Giới thiệu về bản thân..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">{{ old('bio', $user->bio) }}</textarea>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tối đa 500 ký tự</p>
                            @error('bio')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location & Website -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Địa điểm</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}" 
                                       placeholder="Ví dụ: Hà Nội, Việt Nam"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">
                                @error('location')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Website</label>
                                <input type="url" name="website" id="website" value="{{ old('website', $user->website) }}" 
                                       placeholder="https://example.com"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">
                                @error('website')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone & Date of Birth -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                       placeholder="0123456789"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ngày sinh</label>
                                <input type="date" name="date_of_birth" id="date_of_birth"
                                       value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-transparent">
                                @error('date_of_birth')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Privacy Settings -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-primary-100-dark mb-4">Cài đặt quyền riêng tư</h3>
                            <div class="flex items-center">
                                <input type="hidden" name="is_private" value="0">
                                <input type="checkbox" name="is_private" id="is_private" value="1" 
                                       {{ old('is_private', $user->is_private) ? 'checked' : '' }}
                                       class="h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded focus:ring-primary-500 dark:focus:ring-primary-400-dark">
                                <label for="is_private" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Đặt hồ sơ ở chế độ riêng tư
                                </label>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 ml-7">
                                Khi bật tùy chọn này, chỉ bạn mới có thể xem hồ sơ của mình
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('profile.show') }}" 
                               class="px-6 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150">
                                Hủy bỏ
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-primary-600 dark:bg-primary-500-dark text-white rounded-lg hover:bg-primary-700 dark:hover:bg-primary-400-dark transition duration-150">
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Avatar preview functionality
document.getElementById('avatar-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            document.getElementById('upload-btn').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Character counter for bio
document.getElementById('bio').addEventListener('input', function(e) {
    const maxLength = 500;
    const currentLength = e.target.value.length;
    const counterElement = document.querySelector('#bio + p');
    
    counterElement.textContent = `${currentLength}/${maxLength} ký tự`;
    
    if (currentLength > maxLength) {
        counterElement.classList.add('text-red-500');
        counterElement.classList.remove('text-gray-500', 'dark:text-gray-400');
    } else {
        counterElement.classList.remove('text-red-500');
        counterElement.classList.add('text-gray-500', 'dark:text-gray-400');
    }
});
</script>
@endsection
