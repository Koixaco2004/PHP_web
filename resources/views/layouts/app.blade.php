<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Tin Tức')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons - Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/index.js"></script>
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-secondary-50 min-h-screen">
    <!-- Clean Header -->
    <header class="bg-white border-b border-primary-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-900 rounded flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3v9M9 3h6v3H9V3z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-primary-900">VietNews</span>
                    </a>
                </div>

                <!-- Search -->
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <form method="GET" action="{{ route('home') }}" class="w-full">
                        <div class="relative">
                            <input type="text" name="search" 
                                   class="w-full pl-4 pr-10 py-2.5 border border-primary-300 rounded-lg focus:ring-2 focus:ring-primary-900 focus:border-primary-900 text-sm" 
                                   placeholder="Tìm kiếm..." 
                                   value="{{ request('search') }}">
                            <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Navigation -->
                <div class="flex items-center space-x-6">
                    @auth
                        <a href="{{ route('posts.index') }}" class="text-primary-600 hover:text-primary-900 font-medium text-sm">
                            Viết bài
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-primary-600 hover:text-primary-900 font-medium text-sm">
                                Dashboard
                            </a>
                        @endif
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-900 font-medium text-sm">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm">
                            Đăng ký
                        </a>
                    @else
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-primary-900 rounded-full flex items-center justify-center">
                                <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-primary-900">{{ auth()->user()->name }}</span>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                               class="text-primary-600 hover:text-primary-900 text-sm">
                                Đăng xuất
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg animate-slide-up">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg animate-slide-up">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-secondary-200 mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-secondary-500">
                    &copy; {{ date('Y') }} Tin Tức 24h. Mọi quyền được bảo lưu.
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">Trang chủ</a>
                    <a href="#" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">Giới thiệu</a>
                    <a href="#" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors">Liên hệ</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
