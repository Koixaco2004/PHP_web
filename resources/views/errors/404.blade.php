@extends('layouts.app')

@section('title', 'Trang không tìm thấy - 404')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- 404 Illustration -->
        <div class="relative mb-8 animate-bounce">
            <div class="text-9xl font-bold text-primary-900 dark:text-primary-300 select-none">404</div>
        </div>

        <!-- Error Message -->
        <div class="animate-fade-in" style="animation-delay: 0.2s">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-secondary-900 dark:text-primary-400-dark mb-4">
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
                <h2 class="text-2xl font-semibold text-secondary-900 dark:text-primary-400-dark">Tìm kiếm nội dung</h2>
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

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    window.addEventListener('scroll', function() {
        const illustration = document.querySelector('.animate-bounce');
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        if (illustration) {
            illustration.style.transform = `translateY(${rate}px)`;
        }
    });
    
    const searchInput = document.querySelector('input[name="q"]');
    if (searchInput) {
        setTimeout(() => searchInput.focus(), 1000);
    }
});
</script>
@endsection
