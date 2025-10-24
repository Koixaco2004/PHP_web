<div align="center">
  <img src="public/logo.png" alt="Logo" width="200"/>
  
  # SmurfExpress News Portal
  
  Website tin tức được xây dựng bằng Laravel với đầy đủ chức năng quản lý nội dung và hệ thống bình luận.
</div>

## 🚀 Tính năng chính

### Người dùng:

-   Xem danh sách bài viết theo chuyên mục
-   Tìm kiếm bài viết theo từ khóa
-   Đọc chi tiết bài viết
-   Đăng ký/đăng nhập tài khoản
-   Bình luận và trả lời bình luận
-   Đăng nhập qua Google OAuth

### Admin:

-   Dashboard thống kê tổng quan
-   Quản lý bài viết (thêm, sửa, xóa)
-   Quản lý chuyên mục
-   Phê duyệt và xóa bình luận
-   Quản lý người dùng

## 🛠️ Công nghệ sử dụng

-   **Backend:** Laravel 11 (PHP 8.2+)
-   **Database:** MySQL
-   **Frontend:** TailwindCSS + Blade Templates
-   **Authentication:** Laravel Auth + Google OAuth
-   **Image Upload:** ImgBB API

## ⚙️ Yêu cầu hệ thống

-   PHP >= 8.2
-   Composer
-   MySQL (khuyến nghị XAMPP)
-   Node.js >= 18.x

## 🚀 Hướng dẫn setup

### 1. Cài đặt dependencies

```bash
# Clone repository
git clone <repo-url>
cd PHP_web

# Cài đặt PHP packages
composer install

# Cài đặt Node.js packages
npm install
```

### 2. Cấu hình môi trường

```bash
# Copy file môi trường
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Cấu hình database

Mở file `.env` và cập nhật thông tin MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=php_web
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Tạo database

-   Khởi động XAMPP (Apache + MySQL)
-   Truy cập http://localhost/phpmyadmin
-   Tạo database mới tên `php_web`

### 5. Chạy migrations và seed data

```bash
# Tạo bảng và dữ liệu mẫu
php artisan migrate:fresh --seed
```

### 6. Build frontend assets

```bash
npm run build
```

### 7. Chạy ứng dụng

```bash
php artisan serve
```

Truy cập: **http://localhost:8000**

## 🔑 Tài khoản mặc định

Sau khi seed data:

-   **Admin:** admin@example.com / password
-   **User:** test@example.com / password

## 📊 Dữ liệu mẫu

-   **30 người dùng**
-   **10 danh mục**
-   **67 bài viết**
-   **144 hình ảnh bài viết**
-   **465 bình luận**

## 🔧 Cấu hình thêm (tùy chọn)

### Google OAuth

Thêm vào `.env`:

```env
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### ImgBB Upload

Thêm vào `.env`:

```env
IMGBB_API_KEY=your_imgbb_api_key
```

## 📁 Cấu trúc dự án

```
app/
├── Http/Controllers/    # Xử lý logic
├── Models/             # Models (User, Post, Category, Comment)
├── Policies/           # Authorization policies
└── Services/           # Business logic

database/
├── migrations/         # Database schema
├── seeders/           # Dữ liệu mẫu
└── factories/         # Model factories

resources/
└── views/             # Blade templates
```

## 🔄 Lệnh hữu ích

```bash
# Reset database với dữ liệu mẫu
php artisan migrate:fresh --seed

# Clear cache
php artisan cache:clear
php artisan config:clear

# Chạy tests
php artisan test

# Watch mode cho development
npm run dev
```
