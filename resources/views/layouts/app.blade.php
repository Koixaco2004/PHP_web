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
    
    <!-- Custom Scrollbar Styles -->
    <style>
        /* Custom Scrollbar for entire application */
        * {
            scrollbar-width: thin;
            scrollbar-color: #16a34a #f1f5f9;
        }
        
        *::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        *::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        *::-webkit-scrollbar-thumb {
            background: #16a34a;
            border-radius: 10px;
        }
        
        *::-webkit-scrollbar-thumb:hover {
            background: #15803d;
        }
        
        /* Dark mode scrollbar */
        .dark * {
            scrollbar-color: #22c55e #374151;
        }
        
        .dark *::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark *::-webkit-scrollbar-thumb {
            background: #22c55e;
        }
        
        .dark *::-webkit-scrollbar-thumb:hover {
            background: #16a34a;
        }
        
        /* Custom Scrollbar for Modal - Enhanced */
        .modal-scrollbar::-webkit-scrollbar {
            width: 10px;
        }
        
        .modal-scrollbar::-webkit-scrollbar-track {
            background: #e5e7eb;
            border-radius: 10px;
        }
        
        .modal-scrollbar::-webkit-scrollbar-thumb {
            background: #16a34a;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
        }
        
        .modal-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #15803d;
        }
        
        .dark .modal-scrollbar {
            scrollbar-color: #22c55e #1f2937;
        }
        
        .dark .modal-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        .dark .modal-scrollbar::-webkit-scrollbar-thumb {
            background: #22c55e;
            border-color: #1f2937;
        }
        
        .dark .modal-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #16a34a;
        }
    </style>
    
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
                    <button onclick="toggleAboutModal()" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors dark:text-gray-400 dark:hover:text-primary-400-dark">Giới thiệu</button>
                    <button onclick="toggleContactModal()" class="text-sm text-secondary-500 hover:text-primary-600 transition-colors dark:text-gray-400 dark:hover:text-primary-400-dark">Liên hệ</button>
                </div>
            </div>
        </div>
    </footer>

    <!-- About Modal -->
    <div id="aboutModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto modal-scrollbar">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-primary-600 dark:bg-primary-700-dark px-6 py-4 rounded-t-2xl flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-7 h-7 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Giới thiệu
                </h3>
                <button onclick="toggleAboutModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- Logo Section -->
                <div class="flex justify-center mb-6">
                    <div class="bg-gradient-to-br from-primary-100 to-green-100 dark:from-primary-900-dark dark:to-green-900 p-4 rounded-2xl">
                        <img src="{{ asset('logo.png') }}" alt="SmurfExpress Logo" class="w-24 h-24 rounded-xl">
                    </div>
                </div>

                <!-- Welcome Section -->
                <div class="text-center">
                    <h4 class="text-3xl font-bold text-primary-900 dark:text-primary-100-dark mb-3">SmurfExpress</h4>
                    <p class="text-lg text-primary-600 dark:text-primary-400-dark font-medium">Kênh tin tức hàng đầu Việt Nam</p>
                </div>

                <!-- Description -->
                <div class="space-y-4 text-gray-700 dark:text-gray-300">
                    <p class="leading-relaxed text-justify">
                        <span class="font-semibold text-primary-700 dark:text-primary-400-dark">SmurfExpress</span> là nền tảng tin tức trực tuyến hàng đầu, mang đến cho bạn những thông tin nóng hổi, chính xác và đa dạng từ mọi lĩnh vực của cuộc sống.
                    </p>
                    
                    <div class="bg-primary-50 dark:bg-gray-700 rounded-xl p-6 border-l-4 border-primary-600 dark:border-primary-400-dark">
                        <h5 class="font-bold text-primary-900 dark:text-primary-100-dark mb-4 text-lg">Sứ mệnh của chúng tôi:</h5>
                        <ul class="space-y-3 pl-1">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Cung cấp tin tức chính xác, kịp thời và khách quan</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Tạo cộng đồng chia sẻ và thảo luận văn minh</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Đem đến trải nghiệm đọc tin tức hiện đại và tiện lợi</span>
                            </li>
                        </ul>
                    </div>

                    <p class="leading-relaxed text-justify">
                        Với giao diện thân thiện, dễ sử dụng và tối ưu cho mọi thiết bị, chúng tôi cam kết mang đến cho bạn trải nghiệm đọc tin tức tốt nhất. Hãy cùng chúng tôi khám phá thế giới xung quanh mỗi ngày!
                    </p>
                </div>

                <!-- Stats Section -->
                <div class="grid grid-cols-3 gap-4 pt-4">
                    <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-xl">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-300">1000+</div>
                        <div class="text-sm text-blue-700 dark:text-blue-400 mt-1">Bài viết</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-xl">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-300">500+</div>
                        <div class="text-sm text-green-700 dark:text-green-400 mt-1">Thành viên</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-xl">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-300">24/7</div>
                        <div class="text-sm text-orange-700 dark:text-orange-400 mt-1">Cập nhật</div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 rounded-b-2xl flex justify-end">
                <button onclick="toggleAboutModal()" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 dark:bg-primary-700-dark dark:hover:bg-primary-800-dark text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg">
                    Đóng
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contactModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto modal-scrollbar">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-primary-600 dark:bg-primary-700-dark px-6 py-4 rounded-t-2xl flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-7 h-7 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Liên hệ
                </h3>
                <button onclick="toggleContactModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <!-- Contact Info Cards -->
                <div class="space-y-3">
                    <!-- Address -->
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-xl p-4">
                        <h4 class="font-bold text-blue-900 dark:text-blue-100 mb-3 text-lg flex items-center">
                            <div class="w-10 h-10 bg-blue-500 dark:bg-blue-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            Địa chỉ
                        </h4>
                        <p class="text-blue-800 dark:text-blue-200 pl-0">140 Lê Trọng Tấn, Phường Tây Thạnh, TP.HCM</p>
                    </div>

                    <!-- Phone -->
                    <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-xl p-4">
                        <h4 class="font-bold text-green-900 dark:text-green-100 mb-3 text-lg flex items-center">
                            <div class="w-10 h-10 bg-green-500 dark:bg-green-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            Điện thoại
                        </h4>
                        <p class="text-green-800 dark:text-green-200 pl-0">Hotline: <a href="tel:0123456789" class="hover:underline font-semibold">0123 456 789</a></p>
                        <p class="text-green-700 dark:text-green-300 text-sm pl-0 mt-1">Hỗ trợ 24/7</p>
                    </div>

                    <!-- Email -->
                    <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-3 text-lg">Email</h4>
                        <div class="space-y-2">
                            <p class="text-gray-700 dark:text-gray-300">
                                <a href="mailto:contact@smurfexpress.vn" class="hover:underline hover:text-primary-600 dark:hover:text-primary-400-dark font-medium">contact@smurfexpress.vn</a>
                            </p>
                            <p class="text-gray-700 dark:text-gray-300">
                                <a href="mailto:support@smurfexpress.vn" class="hover:underline hover:text-primary-600 dark:hover:text-primary-400-dark">support@smurfexpress.vn</a>
                            </p>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-3 text-lg">Mạng xã hội</h4>
                        <div class="flex space-x-2">
                            <a href="#" class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors shadow-md" style="background-color: #1877F2;" title="Facebook">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors shadow-md" style="background-color: #1DA1F2;" title="Twitter">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors shadow-md" style="background-color: #FF0000;" title="YouTube">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Working Hours -->
                <div class="bg-white dark:bg-gray-700 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                    <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Giờ làm việc
                    </h4>
                    <div class="space-y-2 text-gray-700 dark:text-gray-300 pl-2">
                        <p>Thứ 2 - Thứ 6: 8:00 - 18:00</p>
                        <p>Thứ 7: 9:00 - 17:00</p>
                        <p>Chủ nhật: 9:00 - 12:00</p>
                    </div>
                </div>

                <!-- Quick Note -->
                <div class="text-center p-4 bg-primary-50 dark:bg-gray-700 rounded-xl border border-primary-200 dark:border-gray-600">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        💡 Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Đừng ngần ngại liên hệ với chúng tôi bất cứ lúc nào!
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 rounded-b-2xl flex justify-end">
                <button onclick="toggleContactModal()" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 dark:bg-primary-700-dark dark:hover:bg-primary-800-dark text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg">
                    Đóng
                </button>
            </div>
        </div>
    </div>

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

        // Modal functions
        function toggleAboutModal() {
            const modal = document.getElementById('aboutModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = ''; // Restore scrolling
            }
        }

        function toggleContactModal() {
            const modal = document.getElementById('contactModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = ''; // Restore scrolling
            }
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const aboutModal = document.getElementById('aboutModal');
            const contactModal = document.getElementById('contactModal');

            // Close About modal if clicking on backdrop
            if (event.target === aboutModal) {
                toggleAboutModal();
            }

            // Close Contact modal if clicking on backdrop
            if (event.target === contactModal) {
                toggleContactModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const aboutModal = document.getElementById('aboutModal');
                const contactModal = document.getElementById('contactModal');

                if (!aboutModal.classList.contains('hidden')) {
                    toggleAboutModal();
                }
                if (!contactModal.classList.contains('hidden')) {
                    toggleContactModal();
                }
            }
        });
    </script>
</body>
</html>
