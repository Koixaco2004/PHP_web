@extends('layouts.app')

@section('title', 'Lỗi máy chủ - 500')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- 500 Illustration -->
        <div class="relative mb-6 sm:mb-8">
            <div class="text-6xl sm:text-9xl font-bold text-primary-900 dark:text-primary-300 select-none">500</div>
        </div>

        <!-- Error Message -->
        <div class="">
            <h1 class="text-2xl sm:text-4xl md:text-5xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark mb-3 sm:mb-4 px-4">
                Oops! Có lỗi xảy ra
            </h1>
            <p class="text-sm sm:text-xl text-secondary-600 dark:text-gray-300 mb-6 sm:mb-8 max-w-2xl mx-auto px-4">
                Máy chủ đang gặp vấn đề kỹ thuật. Đội ngũ của chúng tôi đã được thông báo
                và đang khắc phục sự cố. Vui lòng thử lại sau ít phút.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-6 mb-8 sm:mb-12 px-4">
            <button onclick="location.reload()" class="btn-primary inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg w-full sm:w-auto justify-center">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Thử lại
            </button>

            <a href="{{ route('home') }}" class="btn-secondary inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 text-base sm:text-lg w-full sm:w-auto justify-center">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Về trang chủ
            </a>
        </div>

        <!-- Help Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-200 dark:border-gray-700 p-4 sm:p-8 mb-8 sm:mb-12">
            <div class="flex items-center justify-center mb-4 sm:mb-6">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary-600 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-lg sm:text-2xl font-semibold text-secondary-900 dark:text-primary-400-dark">Bạn có thể làm gì?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 text-left">
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-start">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-primary-100 dark:bg-primary-900-dark rounded-full flex items-center justify-center mr-3 sm:mr-4 mt-1 flex-shrink-0">
                            <span class="text-primary-600 font-bold text-xs sm:text-sm">1</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-secondary-900 dark:text-primary-400-dark mb-1 text-sm sm:text-base">Đợi một chút rồi thử lại</h3>
                            <p class="text-secondary-600 dark:text-gray-300 text-xs sm:text-sm">Lỗi có thể là tạm thời. Hãy chờ 2-3 phút rồi tải lại trang.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3 sm:mr-4 mt-1 flex-shrink-0">
                            <span class="text-blue-600 font-bold text-xs sm:text-sm">2</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-secondary-900 dark:text-primary-400-dark mb-1 text-sm sm:text-base">Kiểm tra kết nối internet</h3>
                            <p class="text-secondary-600 dark:text-gray-300 text-xs sm:text-sm">Đảm bảo thiết bị của bạn có kết nối internet ổn định.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-start">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mr-3 sm:mr-4 mt-1 flex-shrink-0">
                            <span class="text-yellow-600 font-bold text-xs sm:text-sm">3</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-secondary-900 dark:text-primary-400-dark mb-1 text-sm sm:text-base">Xóa cache trình duyệt</h3>
                            <p class="text-secondary-600 dark:text-gray-300 text-xs sm:text-sm">Nhấn Ctrl+F5 để tải lại trang hoàn toàn.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mr-3 sm:mr-4 mt-1 flex-shrink-0">
                            <span class="text-purple-600 font-bold text-xs sm:text-sm">4</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-secondary-900 dark:text-primary-400-dark mb-1 text-sm sm:text-base">Liên hệ hỗ trợ</h3>
                            <p class="text-secondary-600 dark:text-gray-300 text-xs sm:text-sm">
                                Nếu vẫn gặp lỗi, hãy <a href="mailto:support@example.com" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium">liên hệ với chúng tôi</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical Info (for developers) -->
        @if(config('app.debug'))
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-200 dark:border-gray-700 p-8">
            <div class="flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-secondary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                <h3 class="text-lg font-semibold text-secondary-900 dark:text-primary-400-dark">Chi tiết kỹ thuật</h3>
            </div>
            <div class="text-center text-sm text-secondary-700 dark:text-gray-300">
                <p class="mb-1">Thời gian: <span class="font-medium">{{ now() }}</span></p>
                <p class="mb-1">Mã lỗi: <span class="font-medium">HTTP 500</span></p>
                <p>Trạng thái: <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                    Đang khắc phục
                </span></p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
