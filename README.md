# Website Tin Tức Laravel

Website tin tức được xây dựng bằng Laravel 11 với các chức năng đầy đủ cho việc quản lý nội dung.

## 🚀 Tính năng chính

### Cho người dùng:
- ✅ Xem danh sách bài viết
- ✅ Tìm kiếm bài viết theo từ khóa
- ✅ Lọc bài viết theo chuyên mục
- ✅ Xem chi tiết bài viết
- ✅ Đăng ký và đăng nhập tài khoản
- ✅ Bình luận bài viết (cần đăng nhập)
- ✅ Trả lời bình luận

### Cho Admin:
- ✅ Dashboard thống kê tổng quan
- ✅ Quản lý bài viết (CRUD)
- ✅ Quản lý chuyên mục (CRUD)
- ✅ Phê duyệt bình luận
- ✅ Xóa bình luận
- ✅ Quản lý người dùng

## 🛠️ Công nghệ sử dụng

- **Backend:** Laravel 11
- **Database:** MySQL
- **Frontend:** Bootstrap 5 + Blade Templates
- **Authentication:** Laravel Auth
- **Authorization:** Policies & Middleware

## 📋 Yêu cầu hệ thống

- PHP >= 8.2
- Composer
- MySQL
- XAMPP/WAMP (khuyến nghị)

## ⚙️ Cài đặt

1. **Clone repository:**
```bash
git clone <repository-url>
cd blog-laravel
```

2. **Cài đặt dependencies:**
```bash
composer install
```

3. **Cấu hình database:**
- Tạo database MySQL
- Copy file `.env.example` thành `.env`
- Cập nhật thông tin database trong `.env`

4. **Chạy migration và seeder:**
```bash
php artisan migrate
php artisan db:seed
```

5. **Khởi chạy server:**
```bash
php artisan serve
```

## 👤 Tài khoản mẫu

### Admin:
- **Email:** admin@example.com
- **Password:** password

### User thường:
- **Email:** user@example.com
- **Password:** password

## 📁 Cấu trúc dự án

```
blog-laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/           # Controllers xử lý đăng nhập/đăng ký
│   │   ├── AdminController.php
│   │   ├── CategoryController.php
│   │   ├── CommentController.php
│   │   ├── HomeController.php
│   │   └── PostController.php
│   ├── Models/             # Eloquent Models
│   ├── Policies/           # Authorization Policies
│   └── Providers/          # Service Providers
├── database/
│   ├── migrations/         # Database migrations
│   ├── seeders/           # Database seeders
│   └── factories/         # Model factories
├── resources/views/       # Blade templates
│   ├── admin/            # Views cho admin
│   ├── auth/             # Views đăng nhập/đăng ký
│   ├── categories/       # Views chuyên mục
│   ├── layouts/          # Layout templates
│   └── posts/            # Views bài viết
└── routes/
    ├── web.php           # Web routes
    └── auth.php          # Authentication routes
```

## 🔐 Phân quyền

### Role: Admin
- Quản lý tất cả bài viết
- Quản lý chuyên mục
- Phê duyệt/xóa bình luận
- Truy cập dashboard admin

### Role: User
- Xem bài viết
- Bình luận bài viết
- Trả lời bình luận

## 🎯 Các chức năng chính

### 1. Quản lý bài viết
- Tạo, sửa, xóa bài viết
- Xuất bản/bản nháp
- Phân trang
- Tìm kiếm và lọc

### 2. Quản lý chuyên mục
- Tạo, sửa, xóa chuyên mục
- Kích hoạt/vô hiệu hóa
- Hiển thị số bài viết

### 3. Hệ thống bình luận
- Bình luận đa cấp (reply)
- Phê duyệt bình luận
- Hiển thị avatar người dùng

### 4. Dashboard Admin
- Thống kê tổng quan
- Bài viết gần đây
- Bình luận chờ duyệt
- Hành động nhanh

## 🚀 Deploy

1. **Production environment:**
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **Cấu hình web server (Apache/Nginx)**
3. **Cấu hình database production**
4. **Cấu hình file .env cho production**

## 📝 Ghi chú

- Website sử dụng Bootstrap 5 cho responsive design
- Tất cả bình luận của user thường cần được admin phê duyệt
- Admin có thể bình luận mà không cần phê duyệt
- Hệ thống sử dụng slug cho URL thân thiện SEO

## 🤝 Đóng góp

1. Fork dự án
2. Tạo feature branch
3. Commit changes
4. Push to branch
5. Tạo Pull Request

## 📄 License

Dự án này được phát hành dưới MIT License.
