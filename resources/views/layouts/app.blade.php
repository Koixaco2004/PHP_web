<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Website Tin Tức')</title>

    @php
        use Illuminate\Support\Facades\Auth;
    @endphp
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons - Heroicons -->
    <script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/index.js"></script>
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-secondary-50 min-h-screen transition-colors duration-300 dark:bg-gray-900 dark:text-white" id="app-body">
    <!-- Clean Header -->
    <header class="bg-white border-b border-primary-200 sticky top-0 z-50 dark:bg-gray-800 dark:border-gray-700">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16" style="align-items: center;">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-0">
                        <img src="{{ asset('logo.png') }}" alt="SmurfExpress Logo" class="w-10 h-10 rounded">
                        <span class="text-xl font-bold text-primary-900 dark:text-primary-100-dark ml-0">SmurfExpress</span>
                    </a>
                </div>

                <!-- Search -->
                <div class="flex-1 max-w-md mx-8 hidden md:flex items-center justify-center">
                    <form method="GET" action="{{ route('search') }}" class="w-full flex items-center">
                        <div class="relative w-full flex items-center">
                            <input type="text" name="q"
                                   class="w-full h-10 pl-4 pr-10 border border-primary-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 focus:outline-none text-sm bg-white flex-shrink-0 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-green-400 dark:focus:border-green-400 dark:focus:outline-none"
                                   placeholder="Tìm kiếm..."
                                   value="{{ request('q') }}">
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 p-1 hover:bg-gray-100 rounded flex items-center justify-center dark:hover:bg-gray-600">
                                <svg class="w-4 h-4 text-primary-500 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Navigation -->
                <div class="flex items-center space-x-6">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" id="darkModeToggle" class="dark-mode-toggle p-2 rounded-lg transition-all duration-200 hover:bg-primary-100 dark:hover:bg-primary-800-dark" title="Chuyển đổi chế độ tối/sáng">
                        <svg id="darkModeIcon" class="w-5 h-5 text-primary-600 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-primary-600 hover:text-primary-900 font-medium text-sm dark:text-primary-400-dark dark:hover:text-primary-300-dark">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('posts.create') }}" class="text-primary-600 hover:text-primary-900 font-medium text-sm dark:text-primary-400-dark dark:hover:text-primary-300-dark">
                                Viết bài
                            </a>
                        @endif
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-900 font-medium text-sm dark:text-primary-400-dark dark:hover:text-primary-300-dark">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm">
                            Đăng ký
                        </a>
                    @else
                        <div class="relative">
                            <div class="flex items-center space-x-3 cursor-pointer" onclick="toggleProfileDropdown()">
                                <div class="w-10 h-10 rounded-full overflow-hidden" style="box-shadow: 0 0 0 2px #10b981;">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <span class="text-sm font-medium text-primary-900 hidden sm:inline dark:text-primary-100-dark">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-primary-600 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            
                            <!-- Dropdown Menu -->
                            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50 dark:bg-gray-800 dark:border-gray-700">
                                <div class="py-1">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Hồ sơ của tôi
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Chỉnh sửa hồ sơ
                                    </a>
                                    <a href="{{ route('profile.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Cài đặt
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                        <div class="border-t border-gray-100 my-1 dark:border-gray-600"></div>
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                            Dashboard
                                        </a>
                                        <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                            </svg>
                                            Quản lý người dùng
                                        </a>
                                        <a href="{{ route('admin.comments.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            Quản lý bình luận
                                        </a>
                                        <a href="{{ route('posts.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3v9M9 3h6v3H9V3z"/>
                                            </svg>
                                            Quản lý bài viết
                                        </a>
                                        <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            Quản lý chuyên mục
                                        </a>
                                    @else
                                        <div class="border-t border-gray-100 my-1 dark:border-gray-600"></div>
                                        <a href="{{ route('posts.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Viết bài
                                        </a>
                                    @endif
                                    <div class="border-t border-gray-100 my-1 dark:border-gray-600"></div>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                                       class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900 dark:hover:bg-opacity-20">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Đăng xuất
                                    </a>
                                </div>
                            </div>
                        </div>
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

    <!-- Navigation Bar -->
    <nav class="bg-primary-900 border-b border-primary-800 dark:bg-primary-100-dark dark:border-primary-200-dark">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-white hover:text-primary-200 text-sm font-medium whitespace-nowrap transition-colors duration-200 dark:text-primary-900-dark dark:hover:text-primary-700-dark {{ request()->routeIs('home') ? 'text-primary-200 dark:text-primary-700-dark' : '' }}">
                        Trang chủ
                    </a>
                    
                    @if(isset($navigationCategories) && $navigationCategories->count() > 0)
                        @php
                            $mainCategories = $navigationCategories->take(5); // Show first 5 categories
                            $moreCategories = $navigationCategories->skip(5); // Remaining categories
                        @endphp
                        
                        @foreach($mainCategories as $category)
                            <a href="{{ route('categories.show', $category) }}" 
                               class="text-white hover:text-primary-200 text-sm font-medium whitespace-nowrap transition-colors duration-200 dark:text-primary-900-dark dark:hover:text-primary-700-dark {{ request()->route('category')?->id == $category->id ? 'text-primary-200 dark:text-primary-700-dark' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                        
                        @if($moreCategories->count() > 0)
                            <!-- More Categories Dropdown -->
                            <div class="relative">
                                <button onclick="toggleCategoriesDropdown()" class="flex items-center space-x-1 text-white hover:text-primary-200 text-sm font-medium whitespace-nowrap transition-colors duration-200 dark:text-primary-900-dark dark:hover:text-primary-700-dark">
                                    <span>Thêm chuyên mục</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div id="categoriesDropdown" class="hidden absolute left-0 mt-2 w-64 bg-white categories-dropdown rounded-lg shadow-lg z-50 overflow-hidden max-w-[calc(100vw-2rem)] dark:bg-gray-800 dark:border dark:border-gray-700">
                                    <div class="py-2 max-h-80 overflow-y-auto overflow-x-hidden">
                                        @foreach($moreCategories as $category)
                                            <a href="{{ route('categories.show', $category) }}" 
                                               class="category-item flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 {{ request()->route('category')?->id == $category->id ? 'bg-primary-50 text-primary-700 dark:bg-primary-900-dark dark:text-primary-100-dark' : '' }}">
                                                @if($category->icon)
                                                    <i class="{{ $category->icon }} w-4 h-4 mr-3 flex-shrink-0 text-gray-500 dark:text-gray-400" 
                                                       @if($category->color) style="color: {{ $category->color }};" @endif></i>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <span class="font-medium">{{ $category->name }}</span>
                                                    @if($category->description)
                                                        <p class="text-xs text-gray-500 truncate mt-0.5 dark:text-gray-400">{{ Str::limit($category->description, 40) }}</p>
                                                    @endif
                                                </div>
                                                @if($category->posts_count > 0)
                                                    <span class="ml-2 inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full dark:bg-gray-700 dark:text-gray-300">{{ $category->posts_count }}</span>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                
                <!-- Mobile Menu Toggle -->
                <div class="md:hidden">
                    <button onclick="toggleMobileNav()" class="text-white hover:text-primary-200 focus:outline-none dark:text-primary-900-dark dark:hover:text-primary-700-dark">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <div id="mobileNav" class="hidden md:hidden pb-3 dark:bg-primary-100-dark">
                <div class="flex flex-col space-y-2">
                    @if(isset($navigationCategories))
                        @foreach($navigationCategories as $category)
                            <a href="{{ route('categories.show', $category) }}" 
                               class="text-white hover:text-primary-200 text-sm font-medium py-2 transition-colors duration-200 dark:text-primary-900-dark dark:hover:text-primary-700-dark {{ request()->route('category')?->id == $category->id ? 'text-primary-200 dark:text-primary-700-dark' : '' }}">
                                @if($category->icon)
                                    <i class="{{ $category->icon }} w-4 h-4 mr-2"></i>
                                @endif
                                {{ $category->name }}
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Đã bỏ thông báo xác thực email -->

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg animate-slide-up dark:bg-green-900 dark:border-green-700 dark:text-green-100">
                <div class="flex">
                    <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-green-800 font-medium dark:text-green-100">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg animate-slide-up dark:bg-red-900 dark:border-red-700 dark:text-red-100">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0 dark:text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-800 font-medium dark:text-red-100">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-secondary-200 mt-12 dark:bg-gray-800 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-sm text-secondary-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} Tin Tức 24h. Mọi quyền được bảo lưu.
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors dark:text-gray-400 dark:hover:text-primary-400-dark">Trang chủ</a>
                    <a href="#" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors dark:text-gray-400 dark:hover:text-primary-400-dark">Giới thiệu</a>
                    <a href="#" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors dark:text-gray-400 dark:hover:text-primary-400-dark">Liên hệ</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Theme Toggle Script -->
    <script>
        // Dark mode toggle functionality
        function toggleDarkMode() {
            const html = document.documentElement;
            const body = document.getElementById('app-body');
            const toggleBtn = document.getElementById('darkModeToggle');
            const icon = document.getElementById('darkModeIcon');

            if (html.classList.contains('dark')) {
                // Switch to light mode
                html.classList.remove('dark');
                body.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>';
            } else {
                // Switch to dark mode
                html.classList.add('dark');
                body.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>';
            }
        }

        // Initialize theme on page load
        function initializeTheme() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const html = document.documentElement;
            const body = document.getElementById('app-body');
            const toggleBtn = document.getElementById('darkModeToggle');
            const icon = document.getElementById('darkModeIcon');

            let shouldBeDark = false;

            if (savedTheme === 'dark') {
                shouldBeDark = true;
            } else if (savedTheme === 'light') {
                shouldBeDark = false;
            } else {
                // Use system preference if no saved theme
                shouldBeDark = prefersDark;
            }

            if (shouldBeDark) {
                html.classList.add('dark');
                body.classList.add('dark');
                if (icon) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>';
                }
            } else {
                html.classList.remove('dark');
                body.classList.remove('dark');
                if (icon) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>';
                }
            }

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('theme')) {
                    if (e.matches) {
                        html.classList.add('dark');
                        body.classList.add('dark');
                        if (icon) {
                            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>';
                        }
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark');
                        if (icon) {
                            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>';
                        }
                    }
                }
            });
        }

        // Initialize theme when DOM is loaded
        document.addEventListener('DOMContentLoaded', initializeTheme);
    </script>
    
    <!-- Dropdown Scripts -->
    <script>
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleCategoriesDropdown() {
            const dropdown = document.getElementById('categoriesDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileNav() {
            const mobileNav = document.getElementById('mobileNav');
            mobileNav.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            // Profile dropdown
            const profileDropdown = document.getElementById('profileDropdown');
            const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');
            
            if (!profileButton && profileDropdown && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }

            // Categories dropdown
            const categoriesDropdown = document.getElementById('categoriesDropdown');
            const categoriesButton = event.target.closest('[onclick="toggleCategoriesDropdown()"]');
            
            if (!categoriesButton && categoriesDropdown && !categoriesDropdown.contains(event.target)) {
                categoriesDropdown.classList.add('hidden');
            }
        });

        // Close mobile nav when clicking on links
        document.addEventListener('DOMContentLoaded', function() {
            const mobileNavLinks = document.querySelectorAll('#mobileNav a');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function() {
                    document.getElementById('mobileNav').classList.add('hidden');
                });
            });
        });
    </script>
</body>
</html>
