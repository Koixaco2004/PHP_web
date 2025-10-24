@extends('layouts.app')

@section('title', 'Trang không tìm thấy - 404')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- 404 Illustration -->
        <div class="relative mb-8 animate-bounce">
            <div class="text-9xl font-bold text-primary-200 dark:text-primary-300 select-none">404</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-32 h-32 text-primary-400 dark:text-primary-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>

        <!-- Error Message -->
        <div class="animate-fade-in" style="animation-delay: 0.2s">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-secondary-900 dark:text-primary-100-dark mb-4">
                Oops! Trang không tìm thấy
            </h1>
            <p class="text-xl text-secondary-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                Có vẻ như trang bạn đang tìm kiếm không tồn tại hoặc đã được chuyển đi. 
                Đừng lo lắng, chúng tôi sẽ giúp bạn tìm lại đường về!
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-12 animate-slide-up" style="animation-delay: 0.4s">
            <a href="{{ route('home') }}" class="btn-primary inline-flex items-center px-8 py-4 text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Về trang chủ
            </a>
            
            <button onclick="history.back()" class="btn-secondary inline-flex items-center px-8 py-4 text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lại
            </button>
        </div>

        <!-- Search Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-secondary-200 dark:border-gray-700 p-8 mb-12 animate-slide-up" style="animation-delay: 0.6s">
            <div class="flex items-center mb-6">
                <svg class="w-6 h-6 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-secondary-900 dark:text-primary-100-dark">Tìm kiếm nội dung</h2>
            </div>
            
            <form action="{{ route('search') ?? route('home') }}" method="GET" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="flex-1">
                    <input type="text" 
                           name="q" 
                           placeholder="Tìm kiếm bài viết, chuyên mục..." 
                           class="w-full px-6 py-4 text-lg border border-secondary-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400-dark focus:border-primary-500 dark:focus:border-primary-400-dark transition-colors duration-200">
                </div>
                <button type="submit" class="btn-primary px-8 py-4 text-lg whitespace-nowrap">
                    Tìm kiếm
                </button>
            </form>
        </div>

        <!-- Popular Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 0.8s">
            <div class="bg-gradient-to-br from-primary-50 dark:from-primary-900 to-primary-100 dark:to-primary-800 rounded-xl p-6 hover:shadow-lg dark:hover:shadow-gray-900/20 transition-shadow duration-300">
                <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-100 mb-2">Bài viết mới nhất</h3>
                <p class="text-primary-700 dark:text-primary-200 text-sm mb-4">Khám phá những nội dung được cập nhật gần đây</p>
                <a href="{{ route('home') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium text-sm">
                    Xem ngay →
                </a>
            </div>

            <div class="bg-gradient-to-br from-primary-50 dark:from-primary-900-dark to-primary-100 dark:to-primary-800-dark rounded-xl p-6 hover:shadow-lg dark:hover:shadow-gray-900/20 transition-shadow duration-300">
                <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-primary-900 dark:text-primary-100-dark mb-2">Chuyên mục</h3>
                <p class="text-primary-700 dark:text-primary-200-dark text-sm mb-4">Duyệt nội dung theo từng lĩnh vực cụ thể</p>
                <a href="{{ route('categories.index') ?? route('home') }}" class="text-primary-600 dark:text-primary-400-dark hover:text-primary-700 dark:hover:text-primary-300-dark font-medium text-sm">
                    Khám phá →
                </a>
            </div>

            <div class="bg-gradient-to-br from-blue-50 dark:from-blue-900 to-blue-100 dark:to-blue-800 rounded-xl p-6 hover:shadow-lg dark:hover:shadow-gray-900/20 transition-shadow duration-300">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Trợ giúp</h3>
                <p class="text-blue-700 dark:text-blue-200 text-sm mb-4">Cần hỗ trợ? Liên hệ với chúng tôi</p>
                <a href="mailto:support@example.com" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm">
                    Liên hệ →
                </a>
            </div>
        </div>

        <!-- Fun Message -->
        <div class="mt-12 p-6 bg-gradient-to-r from-accent-50 dark:from-accent-900 to-accent-100 dark:to-accent-800 rounded-xl animate-fade-in" style="animation-delay: 1s">
            <div class="flex items-center justify-center mb-3">
                <svg class="w-8 h-8 text-accent-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-accent-900 dark:text-accent-100">Đừng buồn!</h3>
            </div>
            <p class="text-accent-700 dark:text-accent-200 text-sm max-w-md mx-auto">
                Ngay cả những lập trình viên giỏi nhất cũng có lúc đi nhầm đường. 
                Quan trọng là biết cách quay lại và tiếp tục hành trình! 🚀
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add typing effect to 404 number
    const number404 = document.querySelector('.text-9xl');
    if (number404) {
        const originalText = '404';
        number404.textContent = '';
        let index = 0;
        
        function typeWriter() {
            if (index < originalText.length) {
                number404.textContent += originalText.charAt(index);
                index++;
                setTimeout(typeWriter, 300);
            }
        }
        
        setTimeout(typeWriter, 500);
    }
    
    // Add parallax effect to illustration
    window.addEventListener('scroll', function() {
        const illustration = document.querySelector('.animate-bounce');
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        if (illustration) {
            illustration.style.transform = `translateY(${rate}px)`;
        }
    });
    
    // Auto-focus search input
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput) {
        setTimeout(() => searchInput.focus(), 1000);
    }
});
</script>
@endsection
