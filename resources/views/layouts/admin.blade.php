<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Website Tin Tức')</title>
    
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

    <style>
        /* Override main content layout for admin */
        .main-content {
            max-width: none;
            margin: 0;
            padding: 0;
            display: block;
            grid-template-columns: none;
            gap: 0;
        }

        .main-content .content-area {
            background: transparent;
            border-radius: 0;
            box-shadow: none;
            overflow: visible;
            padding: 0;
        }

        .main-content .sidebar {
            display: none;
        }
    </style>
</head>
<body class="admin-page">
    <!-- Header -->
    <header class="main-header">
        <div class="header-container">
            <nav class="navbar">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="bi bi-newspaper"></i>
                    VN News
                </a>
                
                <button class="navbar-toggler" type="button" onclick="toggleMobileMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="navbar-menu" id="navbarMenu">
                    <div class="navbar-nav">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house"></i>
                            Trang chủ
                        </a>
                        
                        <a class="nav-link" href="{{ route('posts.index') }}">
                            <i class="bi bi-file-text"></i>
                            Quản lý bài viết
                        </a>
                        
                        <a class="nav-link" href="{{ route('categories.index') }}">
                            <i class="bi bi-tags"></i>
                            Chuyên mục
                        </a>
                        
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            Dashboard
                        </a>
                    </div>

                    <div class="navbar-actions">
                        @auth
                            <div class="user-menu">
                                <button class="user-menu-trigger" onclick="toggleUserMenu()">
                                    <i class="bi bi-person-circle"></i>
                                    {{ Auth::user()->name }}
                                    <i class="bi bi-chevron-down"></i>
                                </button>
                                <div class="user-menu-dropdown" id="userMenuDropdown">
                                    @if(Auth::user()->role == 'admin')
                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                            <i class="bi bi-speedometer2"></i>
                                            Admin
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i>
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Đăng ký</a>
                        @endauth
                    </div>
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
                <div class="alert alert-error alert-dismissible">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3 class="footer-title">VN News</h3>
                    <p class="footer-text">Website tin tức uy tín, cập nhật thông tin nhanh chóng và chính xác, phục vụ nhu cầu thông tin của bạn đọc.</p>
                </div>
                
                <div class="footer-section">
                    <h4 class="footer-subtitle">Danh mục</h4>
                    <ul class="footer-links">
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#">Thể thao</a></li>
                        <li><a href="#">Giải trí</a></li>
                        <li><a href="#">Công nghệ</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4 class="footer-subtitle">Liên hệ</h4>
                    <div class="footer-contact">
                        <p><i class="bi bi-envelope"></i> contact@vnnews.com</p>
                        <p><i class="bi bi-telephone"></i> 0929 456 789</p>
                        <p><i class="bi bi-geo-alt"></i> Hà Nội, Việt Nam</p>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4 class="footer-subtitle">Theo dõi chúng tôi</h4>
                    <div class="social-links">
                        <a href="#" class="social-link facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="social-link youtube"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="social-link instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 VN News. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('navbarMenu');
            menu.classList.toggle('active');
        }

        // User menu toggle
        function toggleUserMenu() {
            const dropdown = document.getElementById('userMenuDropdown');
            dropdown.classList.toggle('active');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const userMenu = document.querySelector('.user-menu');
            const userDropdown = document.getElementById('userMenuDropdown');
            
            if (!userMenu.contains(e.target)) {
                userDropdown.classList.remove('active');
            }
        });

        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 300);
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
