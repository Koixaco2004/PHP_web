<!DOCTYPE html>
<html lang="vi" class="overflow-x-hidden">
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
<body class="bg-secondary-50 min-h-screen transition-colors duration-300 dark:bg-gray-900 dark:text-white overflow-x-hidden" id="app-body">
    <!-- Clean Header -->
    <header class="bg-white border-b border-primary-200 sticky top-0 z-50 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-4 sm:px-8 lg:px-20 xl:px-28">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-1">
                        <img src="{{ asset('logo.png') }}" alt="SmurfExpress Logo" class="w-8 h-8 sm:w-10 sm:h-10 rounded">
                        <span class="text-base sm:text-xl font-bold text-primary-900 dark:text-primary-400-dark">SmurfExpress</span>
                    </a>
                </div>

                <!-- Desktop Search -->
                <div class="flex-1 max-w-md mx-8 hidden lg:flex items-center justify-center">
                    <form method="GET" action="{{ route('search') }}" class="w-full flex items-center">
                        <div class="relative w-full flex items-center">
                            <input type="text" name="q"
                                   class="w-full h-10 pl-4 pr-10 border border-primary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:outline-none text-sm bg-white flex-shrink-0 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark dark:focus:outline-none"
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

                <!-- Right Side Icons -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <!-- Mobile Search Icon (visible on mobile only) -->
                    <button onclick="toggleMobileSearch()" class="lg:hidden p-2 rounded-lg transition-all duration-200 hover:bg-primary-100 dark:hover:bg-primary-800-dark">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" id="darkModeToggle" class="dark-mode-toggle p-2 rounded-lg transition-all duration-200 hover:bg-primary-100 dark:hover:bg-primary-800-dark" title="Chuyển đổi chế độ tối/sáng">
                        <svg id="darkModeIcon" class="w-5 h-5 text-primary-600 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    @auth
                        <!-- Notifications Dropdown -->
                        <div class="relative">
                            <button onclick="toggleNotificationsDropdown()" class="p-2 rounded-lg transition-all duration-200 hover:bg-primary-100 dark:hover:bg-primary-800-dark relative notification-icon">
                                <svg class="w-5 h-5 text-primary-600 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">{{ Auth::user()->unreadNotifications->count() }}</span>
                                @endif
                            </button>
                            
                            <!-- Notifications Dropdown Menu -->
                            <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white border border-gray-200 rounded-lg shadow-lg z-50 dark:bg-gray-800 dark:border-gray-700 max-h-96 overflow-y-auto" style="z-index: 60;">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-600 flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Thông báo</h3>
                                        @if(Auth::user()->unreadNotifications->count() > 0)
                                            <button class="mark-all-read-btn text-xs text-primary-600 dark:text-primary-400 hover:underline">Đánh dấu tất cả đã đọc</button>
                                        @endif
                                    </div>
                                    @forelse(Auth::user()->notifications()->take(10)->get() as $notification)
                                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer notification-item" data-notification-id="{{ $notification->id }}">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    @if(($notification->data['type'] ?? '') == 'approved')
                                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    @elseif(($notification->data['type'] ?? '') == 'rejected')
                                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    @elseif(($notification->data['type'] ?? '') == 'reply')
                                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm text-gray-900 dark:text-white">{{ $notification->data['message'] ?? 'Thông báo mới' }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                                @if($notification->read_at == null)
                                                    <div class="flex items-center space-x-2">
                                                        <button onclick="event.stopPropagation(); markAsReadOnly('{{ $notification->id }}')" class="p-1 hover:bg-gray-200 dark:hover:bg-gray-600 rounded mark-read-btn" title="Đánh dấu đã đọc">
                                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </button>
                                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Không có thông báo nào
                                        </div>
                                    @endforelse
                                    @if(Auth::user()->notifications->count() > 10)
                                        <div class="px-4 py-2 text-center">
                                            <a href="#" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">Xem tất cả</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Avatar - Desktop Only -->
                        <div class="relative hidden sm:block">
                            <div class="flex items-center space-x-2 cursor-pointer" onclick="toggleProfileDropdown()">
                                <div class="w-8 h-8 rounded-full overflow-hidden ring-2 ring-primary-500 flex-shrink-0">
                                    @if(Auth::user()->avatar)
                                        @if(Str::startsWith(Auth::user()->avatar, ['http://', 'https://']))
                                            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('hello.png') }}'">
                                        @else
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover" onerror="this.src='{{ asset('hello.png') }}'">
                                        @endif
                                    @else
                                        <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <svg class="w-4 h-4 text-primary-600 dark:text-primary-400-dark hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            
                            <!-- Profile Dropdown Menu -->
                            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50 dark:bg-gray-800 dark:border-gray-700">
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center space-x-3">
                                        @if(Auth::user()->avatar)
                                            @if(Str::startsWith(Auth::user()->avatar, ['http://', 'https://']))
                                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover" onerror="this.src='{{ asset('hello.png') }}'">
                                            @else
                                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-full object-cover" onerror="this.src='{{ asset('hello.png') }}'">
                                            @endif
                                        @else
                                            <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-10 h-10 rounded-full object-cover">
                                        @endif
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-2">
                                    <a href="{{ route('users.show', Auth::user()) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Trang cá nhân
                                        </div>
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Cài đặt tài khoản
                                        </div>
                                    </a>
                                    <a href="{{ route('profile.posts') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Bài viết của tôi
                                        </div>
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                                Quản trị
                                            </div>
                                        </a>
                                    @endif
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Đăng xuất
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Guest Actions - Desktop Only -->
                        <a href="{{ route('login') }}" class="hidden lg:block text-primary-600 hover:text-primary-900 font-medium text-sm dark:text-primary-400-dark dark:hover:text-primary-300-dark">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="hidden lg:block btn-primary text-sm">
                            Đăng ký
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg transition-all duration-200 hover:bg-primary-100 dark:hover:bg-primary-800-dark">
                        <svg id="mobileMenuIcon" class="w-6 h-6 text-primary-600 dark:text-primary-400-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar (slides down) -->
        <div id="mobileSearchBar" class="hidden lg:hidden bg-white dark:bg-gray-800 border-t border-primary-200 dark:border-gray-700 px-4 py-3">
            <form method="GET" action="{{ route('search') }}" class="w-full">
                <div class="relative w-full flex items-center">
                    <input type="text" name="q"
                           class="w-full h-10 pl-4 pr-10 border border-primary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 focus:outline-none text-sm bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-400-dark dark:focus:border-primary-400-dark"
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

        <!-- Mobile Menu Overlay -->
        <div id="mobileMenuOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" onclick="toggleMobileMenu()"></div>
        
        <!-- Mobile Menu Sidebar -->
        <div id="mobileMenu" class="hidden fixed top-0 right-0 h-full w-80 bg-white dark:bg-gray-800 shadow-2xl z-50 lg:hidden transform transition-transform duration-300" style="display: none; flex-direction: column;">
            <!-- Fixed Header -->
            <div class="flex-shrink-0 p-4 border-b border-gray-200 dark:border-gray-700">
                <!-- Close Button -->
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-primary-900 dark:text-primary-400-dark">Menu</h2>
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-4">
                @auth
                    <!-- User Profile Section -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center space-x-3 mb-4">
                            @if(Auth::user()->avatar)
                                @if(Str::startsWith(Auth::user()->avatar, ['http://', 'https://']))
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full object-cover" onerror="this.src='{{ asset('hello.png') }}'">
                                @else
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full object-cover" onerror="this.src='{{ asset('hello.png') }}'">
                                @endif
                            @else
                                <img src="{{ asset('hello.png') }}" alt="Default Avatar" class="w-12 h-12 rounded-full object-cover">
                            @endif
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('users.show', Auth::user()) }}" class="block text-sm text-primary-600 dark:text-primary-400-dark hover:underline">Trang cá nhân</a>
                            <a href="{{ route('profile.edit') }}" class="block text-sm text-primary-600 dark:text-primary-400-dark hover:underline">Cài đặt tài khoản</a>
                        </div>
                    </div>
                @else
                    <!-- Guest Actions -->
                    <div class="mb-6 space-y-2">
                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 text-primary-600 dark:text-primary-400-dark border border-primary-600 dark:border-primary-400-dark rounded-lg hover:bg-primary-50 dark:hover:bg-gray-700">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                            Đăng ký
                        </a>
                    </div>
                @endauth

                <!-- Navigation Links -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Điều hướng</h3>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg {{ request()->routeIs('home') ? 'bg-gray-100 dark:bg-gray-700' : '' }}" onclick="toggleMobileMenu()">
                            Trang chủ
                        </a>
                        @auth
                            <a href="{{ route('posts.create') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg" onclick="toggleMobileMenu()">
                                Viết bài
                            </a>
                            <a href="{{ route('profile.posts') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg" onclick="toggleMobileMenu()">
                                Bài viết của tôi
                            </a>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg" onclick="toggleMobileMenu()">
                                    Quản trị
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Categories -->
                @if(isset($navigationCategories) && $navigationCategories->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">Chuyên mục</h3>
                        <div class="relative">
                            <div class="max-h-[300px] overflow-y-auto space-y-2 pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(156, 163, 175, 0.5) transparent;">
                                @foreach($navigationCategories as $category)
                                    <a href="{{ route('categories.show', $category) }}" 
                                       class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg {{ request()->route('category') && request()->route('category')->id == $category->id ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                                       onclick="toggleMobileMenu()">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                            <!-- Gradient fade overlay -->
                            <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-white dark:from-gray-800 to-transparent pointer-events-none"></div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Fixed Footer -->
            @auth
                <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Đăng xuất
                        </div>
                    </a>
                </div>
            @endauth
        </div>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </header>

    <!-- Navigation Bar - Desktop Only -->
    <nav class="bg-primary-900 border-b border-primary-800 dark:bg-primary-100-dark dark:border-primary-200-dark hidden lg:block">
        <div class="px-4 sm:px-8 lg:px-20 xl:px-28">
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-white hover:text-primary-200 text-sm font-medium whitespace-nowrap transition-colors duration-200 dark:text-primary-900-dark dark:hover:text-primary-700-dark {{ request()->routeIs('home') ? 'text-primary-200 dark:text-primary-700-dark' : '' }}">
                        Trang chủ
                    </a>
                    
                    @if(isset($navigationCategories) && $navigationCategories->count() > 0)
                        @php
                            $mainCategories = $navigationCategories->take(6);
                            $moreCategories = $navigationCategories->skip(6);
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
                                               class="category-item flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 {{ request()->route('category')?->id == $category->id ? 'bg-primary-50 text-primary-700 dark:bg-primary-900-dark dark:text-primary-400-dark' : '' }}">
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
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="px-4 sm:px-8 lg:px-20 xl:px-28 py-8">
        @yield('content')
    </main>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-50 space-y-2"></div>

    <!-- Confirmation Modal -->
    @include('partials.confirmation-modal')

    <!-- Modern Footer -->
    <footer class="bg-secondary-50 dark:bg-gray-900 text-gray-900 dark:text-white mt-12 border-t border-gray-200 dark:border-gray-700">
        <div class="px-8 sm:px-12 lg:px-20 xl:px-28">
            <!-- Main Footer Content -->
            <div class="py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                    <!-- About Section -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="{{ asset('logo.png') }}" alt="SmurfExpress Logo" class="w-12 h-12 rounded-lg">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">SmurfExpress</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                            Kênh tin tức hàng đầu Việt Nam, mang đến những thông tin nóng hổi, chính xác và đa dạng từ mọi lĩnh vực của cuộc sống.
                        </p>
                        <div class="flex space-x-3 pt-2">
                            <a href="#" class="w-10 h-10 rounded-lg flex items-center justify-center bg-blue-100 dark:bg-blue-600 hover:bg-blue-200 dark:hover:bg-blue-700 transition-colors duration-200" title="Facebook">
                                <svg class="w-5 h-5 text-blue-600 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-lg flex items-center justify-center bg-sky-100 dark:bg-sky-500 hover:bg-sky-200 dark:hover:bg-sky-600 transition-colors duration-200" title="Twitter">
                                <svg class="w-5 h-5 text-sky-600 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-lg flex items-center justify-center bg-red-100 dark:bg-red-600 hover:bg-red-200 dark:hover:bg-red-700 transition-colors duration-200" title="YouTube">
                                <svg class="w-5 h-5 text-red-600 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Liên kết nhanh</h4>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    Trang chủ
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('categories.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    Chuyên mục
                                </a>
                            </li>
                            @auth
                            <li>
                                <a href="{{ route('profile.posts') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    Bài viết của tôi
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('profile.show') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    Hồ sơ
                                </a>
                            </li>
                            @if(Auth::user()->isAdmin())
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            @endif
                            @endauth
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Liên hệ</h4>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start text-gray-600 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>140 Lê Trọng Tấn, Phường Tây Thạnh, TP.HCM</span>
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <a href="tel:0123456789" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">0123 456 789</a>
                            </li>
                            <li class="flex items-center text-gray-600 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:contact@smurfexpress.vn" class="hover:text-primary-600 dark:hover:text-primary-400 transition-colors">contact@smurfexpress.vn</a>
                            </li>
                        </ul>
                        
                        <div class="mt-4 p-3 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center text-xs text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white">Giờ làm việc:</div>
                                    <div>T2-T6: 8:00-18:00</div>
                                    <div>T7-CN: 9:00-17:00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-200 dark:border-gray-700 py-6 sm:py-8">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <div class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm text-center sm:text-left">
                        © {{ date('Y') }} <span class="font-semibold text-gray-900 dark:text-white">SmurfExpress</span>. All rights reserved.
                    </div>
                    <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-xs sm:text-sm">
                        <a href="{{ route('privacy-policy') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Chính sách bảo mật</a>
                        <a href="{{ route('terms-of-service') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Điều khoản sử dụng</a>
                        <a href="{{ route('support') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">Hỗ trợ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Theme Toggle Script -->
    <script>
        function toggleDarkMode() {
            const html = document.documentElement;
            const body = document.getElementById('app-body');
            const toggleBtn = document.getElementById('darkModeToggle');
            const icon = document.getElementById('darkModeIcon');

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                body.classList.remove('dark');
                try {
                    localStorage.setItem('theme', 'light');
                } catch (e) {
                    console.warn('Unable to save theme preference:', e);
                }
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>';
            } else {
                html.classList.add('dark');
                body.classList.add('dark');
                try {
                    localStorage.setItem('theme', 'dark');
                } catch (e) {
                    console.warn('Unable to save theme preference:', e);
                }
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>';
            }
        }

        function initializeTheme() {
            let savedTheme;
            try {
                savedTheme = localStorage.getItem('theme');
            } catch (e) {
                console.warn('Unable to access localStorage for theme:', e);
                savedTheme = null;
            }
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

            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                let currentTheme;
                try {
                    currentTheme = localStorage.getItem('theme');
                } catch (err) {
                    currentTheme = null;
                }
                if (!currentTheme) {
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

        document.addEventListener('DOMContentLoaded', initializeTheme);
    </script>
    
    <!-- Dropdown Scripts -->
    <script>
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleNotificationsDropdown() {
            const dropdown = document.getElementById('notificationsDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleCategoriesDropdown() {
            const dropdown = document.getElementById('categoriesDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            const mobileMenuIcon = document.getElementById('mobileMenuIcon');
            
            // Toggle display flex/none for mobile menu
            if (mobileMenu.style.display === 'flex') {
                mobileMenu.style.display = 'none';
                mobileMenu.classList.add('hidden');
                mobileMenuOverlay.classList.add('hidden');
                mobileMenuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>';
            } else {
                mobileMenu.style.display = 'flex';
                mobileMenu.classList.remove('hidden');
                mobileMenuOverlay.classList.remove('hidden');
                mobileMenuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            }
        }

        function toggleMobileSearch() {
            const searchBar = document.getElementById('mobileSearchBar');
            searchBar.classList.toggle('hidden');
        }

        function markAsReadOnly(notificationId) {
            fetch(`/notifications/${notificationId}/mark-as-read-only`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI: hide the mark as read button and the blue dot
                    const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (notificationElement) {
                        const markButton = notificationElement.querySelector('.mark-read-btn');
                        const dot = notificationElement.querySelector('.bg-blue-500');
                        if (markButton) markButton.parentElement.remove();
                        if (dot) dot.remove();
                    }
                    // Update unread count
                    updateUnreadCount();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function redirectToNotification(notificationId) {
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.redirect_url) {
                    window.location.href = data.redirect_url;
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function updateUnreadCount() {
            // Optionally, update the unread count badge
            fetch('/api/notifications/unread-count', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-icon .bg-red-500');
                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count;
                    } else {
                        badge.remove();
                    }
                }
            })
            .catch(error => console.error('Error updating count:', error));
        }

        function markAllAsRead() {
            fetch('/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide all mark as read buttons and dots
                    const markButtons = document.querySelectorAll('.mark-read-btn');
                    markButtons.forEach(button => button.parentElement.remove());
                    const dots = document.querySelectorAll('.bg-blue-500');
                    dots.forEach(dot => dot.remove());
                    // Update unread count
                    updateUnreadCount();
                    // Hide the mark all button
                    const markAllButton = document.querySelector('.mark-all-read-btn');
                    if (markAllButton) markAllButton.remove();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profileDropdown');
            const profileButton = event.target.closest('[onclick="toggleProfileDropdown()"]');
            
            if (!profileButton && profileDropdown && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }

            const notificationsDropdown = document.getElementById('notificationsDropdown');
            const notificationsButton = event.target.closest('[onclick="toggleNotificationsDropdown()"]');
            
            if (!notificationsButton && notificationsDropdown && !notificationsDropdown.contains(event.target)) {
                notificationsDropdown.classList.add('hidden');
            }

            const categoriesDropdown = document.getElementById('categoriesDropdown');
            const categoriesButton = event.target.closest('[onclick="toggleCategoriesDropdown()"]');
            
            if (!categoriesButton && categoriesDropdown && !categoriesDropdown.contains(event.target)) {
                categoriesDropdown.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const mobileNavLinks = document.querySelectorAll('#mobileNav a');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function() {
                    document.getElementById('mobileNav').classList.add('hidden');
                });
            });

            // Add event listeners for notifications
            const notificationItems = document.querySelectorAll('.notification-item');
            notificationItems.forEach(item => {
                item.addEventListener('click', function() {
                    const id = this.getAttribute('data-notification-id');
                    redirectToNotification(id);
                });
            });

            const markReadButtons = document.querySelectorAll('.mark-read-btn');
            markReadButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const id = this.closest('[data-notification-id]').getAttribute('data-notification-id');
                    markAsReadOnly(id);
                });
            });

            const markAllButton = document.querySelector('.mark-all-read-btn');
            if (markAllButton) {
                markAllButton.addEventListener('click', function() {
                    markAllAsRead();
                });
            }
        });

        // Toast Notification System
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            // Icon based on type
            const icons = {
                success: `<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>`,
                error: `<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>`,
                info: `<svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>`,
                warning: `<svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>`
            };

            toast.className = 'flex items-center w-full max-w-sm p-4 mb-2 text-gray-900 bg-white rounded-lg shadow-lg dark:bg-gray-800 dark:text-white border-l-4 border-' + (type === 'success' ? 'green' : type === 'error' ? 'red' : type === 'warning' ? 'yellow' : 'blue') + '-500 animate-slide-in-right';
            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-lg">
                    ${icons[type] || icons.success}
                </div>
                <div class="ml-3 text-sm font-medium flex-1">${message}</div>
                <button type="button" onclick="this.parentElement.remove()" class="ml-auto -mx-1.5 -my-1.5 bg-white dark:bg-gray-800 text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 inline-flex h-8 w-8 items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            `;

            container.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // Show toast on page load if there's a session message or URL parameter
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif

        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif

        @if(session('info'))
            showToast("{{ session('info') }}", 'info');
        @endif

        @if(session('warning'))
            showToast("{{ session('warning') }}", 'warning');
        @endif

        // Check URL parameters for verified email
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('verified') === '1') {
            showToast('Email của bạn đã được xác thực thành công!', 'success');
            // Clean URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
</body>
</html>
