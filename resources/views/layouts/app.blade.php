<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Website Tin Tức')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">
    @stack('styles')
    @yield('additional_css')
</head>
<body class="@yield('body_class')">
    <!-- Header -->
    <header class="main-header">
        <div class="header-container">
            <nav class="navbar">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="bi bi-newspaper"></i>
                    VN News
                </a>
                
                <button class="navbar-toggler" type="button" onclick="toggleMobileMenu()">
                    <i class="bi bi-list"></i>
                </button>
                
                <div class="navbar-nav" id="navbarNav">
                    <div class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house"></i> Trang chủ
                        </a>
                    </div>
                    @auth
                        <div class="nav-item">
                            <a class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                                <i class="bi bi-journal-text"></i> Quản lý bài viết
                            </a>
                        </div>
                        @if(auth()->user()->isAdmin())
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <i class="bi bi-folder"></i> Chuyên mục
                                </a>
                            </div>
                        @endif
                    @endauth
                    
                    @guest
                        <div class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Đăng ký
                            </a>
                        </div>
                    @else
                        <div class="nav-item dropdown">
                            <a class="nav-link" href="#">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                                @if(auth()->user()->isAdmin())
                                    <span class="user-badge">Admin</span>
                                @endif
                                <i class="bi bi-chevron-down" style="font-size: 0.8rem; margin-left: 0.5rem;"></i>
                            </a>
                            <div class="dropdown-menu">
                                @if(auth()->user()->isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Dashboard
                                    </a>
                                    <hr class="dropdown-divider">
                                @endif
                                <button type="button" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                </button>
                            </div>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-area">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
        
        <aside class="sidebar">
            @yield('sidebar')
        </aside>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4><i class="bi bi-newspaper"></i> VN News</h4>
                <p>Website tin tức uy tín, cập nhật thông tin nhanh chóng và chính xác. Nơi hội tụ những tin tức hot nhất trong và ngoài nước.</p>
            </div>
            <div class="footer-section">
                <h4>Danh mục</h4>
                <p><a href="{{ route('home') }}">Trang chủ</a></p>
                <p><a href="#">Tin tức</a></p>
                <p><a href="#">Thể thao</a></p>
                <p><a href="#">Giải trí</a></p>
                <p><a href="#">Công nghệ</a></p>
            </div>
            <div class="footer-section">
                <h4>Liên hệ</h4>
                <p><i class="bi bi-envelope"></i> contact@vnnews.com</p>
                <p><i class="bi bi-telephone"></i> 0123 456 789</p>
                <p><i class="bi bi-geo-alt"></i> Hà Nội, Việt Nam</p>
            </div>
            <div class="footer-section">
                <h4>Theo dõi chúng tôi</h4>
                <p><i class="bi bi-facebook"></i> Facebook</p>
                <p><i class="bi bi-twitter"></i> Twitter</p>
                <p><i class="bi bi-youtube"></i> YouTube</p>
                <p><i class="bi bi-instagram"></i> Instagram</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} VN News. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const nav = document.getElementById('navbarNav');
            nav.classList.toggle('show');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const nav = document.getElementById('navbarNav');
            const toggle = document.querySelector('.navbar-toggler');
            
            if (!nav.contains(event.target) && !toggle.contains(event.target)) {
                nav.classList.remove('show');
            }
        });
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });
        });
    </script>
    
    @yield('additional_js')
</body>
</html>
