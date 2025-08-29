@extends('layouts.app')

@section('title', 'Lỗi máy chủ - 500')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-4xl mx-auto text-center">
        <!-- 500 Illustration -->
        <div class="relative mb-8">
            <div class="text-9xl font-bold text-red-200 select-none animate-pulse">500</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-32 h-32 text-red-400 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>

        <!-- Error Message -->
        <div class="animate-fade-in" style="animation-delay: 0.2s">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-secondary-900 mb-4">
                Oops! Có lỗi xảy ra
            </h1>
            <p class="text-xl text-secondary-600 mb-8 max-w-2xl mx-auto">
                Máy chủ đang gặp vấn đề kỹ thuật. Đội ngũ của chúng tôi đã được thông báo 
                và đang khắc phục sự cố. Vui lòng thử lại sau ít phút.
            </p>
        </div>

        <!-- Status Information -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6 mb-8 animate-slide-up" style="animation-delay: 0.4s">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-red-900">Thông tin lỗi</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="font-semibold text-red-900">Thời gian xảy ra</h3>
                    </div>
                    <p class="text-red-700" id="errorTime">{{ now()->format('H:i:s d/m/Y') }}</p>
                </div>
                
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M3 9h2m14 0h2M3 15h2m14 0h2M7 12h10M7 8h10m-10 8h10"/>
                        </svg>
                        <h3 class="font-semibold text-red-900">Mã lỗi</h3>
                    </div>
                    <p class="text-red-700 font-mono">HTTP 500</p>
                </div>
                
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <h3 class="font-semibold text-red-900">Trạng thái</h3>
                    </div>
                    <p class="text-red-700">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Đang khắc phục
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-12 animate-slide-up" style="animation-delay: 0.6s">
            <button onclick="location.reload()" class="btn-primary inline-flex items-center px-8 py-4 text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Thử lại
            </button>
            
            <a href="{{ route('home') }}" class="btn-secondary inline-flex items-center px-8 py-4 text-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Về trang chủ
            </button>
        </div>

        <!-- What to do section -->
        <div class="bg-white rounded-2xl shadow-xl border border-secondary-200 p-8 animate-slide-up" style="animation-delay: 0.8s">
            <div class="flex items-center justify-center mb-6">
                <svg class="w-6 h-6 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-secondary-900">Bạn có thể làm gì?</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <span class="text-green-600 font-bold text-sm">1</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-secondary-900 mb-1">Đợi một chút rồi thử lại</h3>
                            <p class="text-secondary-600 text-sm">Lỗi có thể là tạm thời. Hãy chờ 2-3 phút rồi tải lại trang.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <span class="text-blue-600 font-bold text-sm">2</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-secondary-900 mb-1">Kiểm tra kết nối internet</h3>
                            <p class="text-secondary-600 text-sm">Đảm bảo thiết bị của bạn có kết nối internet ổn định.</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <span class="text-yellow-600 font-bold text-sm">3</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-secondary-900 mb-1">Xóa cache trình duyệt</h3>
                            <p class="text-secondary-600 text-sm">Nhấn Ctrl+F5 để tải lại trang hoàn toàn.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <span class="text-purple-600 font-bold text-sm">4</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-secondary-900 mb-1">Liên hệ hỗ trợ</h3>
                            <p class="text-secondary-600 text-sm">
                                Nếu vẫn gặp lỗi, hãy <a href="mailto:support@example.com" class="text-primary-600 hover:text-primary-700 font-medium">liên hệ với chúng tôi</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical Info (for developers) -->
        @if(config('app.debug'))
        <div class="mt-8 p-6 bg-secondary-100 rounded-xl text-left animate-fade-in" style="animation-delay: 1s">
            <details class="cursor-pointer">
                <summary class="font-semibold text-secondary-900 mb-4 select-none hover:text-primary-600">
                    🔧 Thông tin kỹ thuật (dành cho nhà phát triển)
                </summary>
                <div class="mt-4 p-4 bg-secondary-800 rounded-lg text-green-400 font-mono text-sm overflow-x-auto">
                    <div class="space-y-2">
                        <div><span class="text-secondary-400">Thời gian:</span> {{ now() }}</div>
                        <div><span class="text-secondary-400">User Agent:</span> {{ request()->header('User-Agent') }}</div>
                        <div><span class="text-secondary-400">IP:</span> {{ request()->ip() }}</div>
                        <div><span class="text-secondary-400">URL:</span> {{ request()->fullUrl() }}</div>
                        <div><span class="text-secondary-400">Method:</span> {{ request()->method() }}</div>
                    </div>
                </div>
            </details>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-reload countdown
    let countdown = 30;
    const countdownElement = document.createElement('div');
    countdownElement.className = 'fixed bottom-4 right-4 bg-white rounded-lg shadow-lg border border-secondary-200 p-4 text-sm';
    countdownElement.innerHTML = `
        <div class="flex items-center">
            <svg class="w-4 h-4 text-primary-600 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span>Tự động thử lại sau <span id="countdown">${countdown}</span>s</span>
            <button onclick="clearInterval(autoReload); this.parentElement.parentElement.remove();" class="ml-2 text-secondary-400 hover:text-secondary-600">×</button>
        </div>
    `;
    document.body.appendChild(countdownElement);
    
    const autoReload = setInterval(() => {
        countdown--;
        const countdownSpan = document.getElementById('countdown');
        if (countdownSpan) {
            countdownSpan.textContent = countdown;
        }
        
        if (countdown <= 0) {
            location.reload();
        }
    }, 1000);
    
    // Add glitch effect to 500 number
    const number500 = document.querySelector('.text-9xl');
    if (number500) {
        setInterval(() => {
            number500.style.textShadow = `
                ${Math.random() * 10 - 5}px ${Math.random() * 10 - 5}px 0 rgba(239, 68, 68, 0.8),
                ${Math.random() * 10 - 5}px ${Math.random() * 10 - 5}px 0 rgba(59, 130, 246, 0.8)
            `;
            setTimeout(() => {
                number500.style.textShadow = 'none';
            }, 100);
        }, 2000);
    }
});
</script>

<style>
@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}
</style>
@endsection
