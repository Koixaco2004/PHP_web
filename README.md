<div align="center">
  <img src="public/logo.png" alt="Logo" width="200"/>

# SmurfExpress News Portal

**Hệ thống Portal tin tức chuyên nghiệp** được xây dựng bằng Laravel 12 với kiến trúc hiện đại, đầy đủ tính năng quản lý nội dung (CMS), hệ thống phê duyệt bài viết, thông báo real-time và tích hợp API bên thứ ba.

Đây là đồ án môn học **Lập trình mã nguồn mở** của nhóm 4 thành viên.

</div>

## 🚀 Tính năng chính

### 🎯 Người dùng thường (User):

-   Đăng ký/đăng nhập với email & password, Google OAuth.
-   Tạo và quản lý bài viết với trình soạn thảo rich text, upload hình ảnh qua ImgBB API.
-   Tìm kiếm nâng cao, bình luận phân cấp, nhận thông báo real-time.
-   Quản lý profile cá nhân và đổi mật khẩu.

### 👨‍💼 Quản trị viên (Admin):

-   Dashboard tổng quan với thống kê.
-   Phê duyệt/từ chối bài viết, quản lý chuyên mục, người dùng và bình luận.
-   Quyền phân cấp với Policies và Middleware.

## 🛠️ Công nghệ sử dụng

### Backend:

-   **Framework:** Laravel 12.x (PHP 8.2+)
-   **ORM:** Eloquent
-   **Authentication:** Laravel Auth + Google OAuth
-   **Notifications:** Database channel

### Database:

-   **RDBMS:** MySQL 8.x
-   **Migrations & Seeders:** Với dữ liệu mẫu

### Frontend:

-   **CSS Framework:** TailwindCSS
-   **JavaScript:** Vanilla JS + Axios
-   **Build Tool:** Vite

### API & Services:

-   **OAuth:** Google OAuth 2.0
-   **Image Hosting:** ImgBB API
-   **Email:** Laravel Mail

## ⚙️ Yêu cầu hệ thống

-   PHP >= 8.2, Composer, MySQL, Node.js >= 18.x, NPM.

## 🚀 Hướng dẫn cài đặt

### Bước 1: Clone repository

```bash
git clone https://github.com/Koixaco2004/PHP_web.git
cd PHP_web
```

### Bước 2: Cài đặt dependencies

```bash
composer install
npm install
```

### Bước 3: Cấu hình môi trường

```bash
copy .env.example .env
php artisan key:generate
```

Cập nhật thông tin database trong `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=php_web
DB_USERNAME=root
DB_PASSWORD=
```

### Bước 4: Tạo database và chạy migrations

```bash
php artisan migrate:fresh --seed
```

### Bước 5: Cấu hình tùy chọn (Optional)

#### Google OAuth (Đăng nhập Google):

1. Truy cập [Google Cloud Console](https://console.cloud.google.com/)
2. Tạo OAuth 2.0 Client ID và thêm redirect URI: `http://localhost:8000/auth/google/callback`
3. Thêm vào `.env`:
    ```env
    GOOGLE_CLIENT_ID=your_google_client_id_here
    GOOGLE_CLIENT_SECRET=your_google_client_secret_here
    ```

#### ImgBB API (Upload hình ảnh):

1. Đăng ký tại [ImgBB](https://imgbb.com/) và lấy API Key
2. Thêm vào `.env`:
    ```env
    IMGBB_API_KEY=your_imgbb_api_key_here
    ```

#### Email (Thông báo qua email):

Cấu hình SMTP trong `.env` (ví dụ Gmail):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

### Bước 6: Build assets và chạy server

```bash
npm run dev
php artisan serve
```

Truy cập: http://localhost:8000

## 🔑 Tài khoản mặc định

-   **Admin:** admin@example.com / password
-   **User:** test@example.com / password

## 👥 Authors

-   **Trần Công Minh**
-   **Lê Đức Trung**
-   **Tạ Nguyên Vũ**
-   **Nguyễn Chí Tài**

---

<div align="center">
  <p>Made with ❤️ by SmurfExpress Team</p>
</div>
