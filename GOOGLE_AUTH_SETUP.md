# Hướng dẫn cấu hình Google Authentication và Email Verification

## 1. Cấu hình Google OAuth

### Bước 1: Tạo Google OAuth Application
1. Truy cập [Google Cloud Console](https://console.cloud.google.com/)
2. Tạo project mới hoặc chọn project hiện có
3. Kích hoạt Google+ API
4. Tạo OAuth 2.0 credentials:
   - Authorized redirect URIs: `http://localhost:8000/auth/google/callback`
   - Lấy Client ID và Client Secret

### Bước 2: Cấu hình .env
Thêm vào file `.env`:
```
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## 2. Cấu hình Email

### Sử dụng Gmail SMTP (khuyến nghị cho development)
Thêm vào file `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Lưu ý:** Sử dụng App Password thay vì mật khẩu thông thường cho Gmail.

### Hoặc sử dụng Mailtrap (cho testing)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

## 3. Chạy ứng dụng

### Cài đặt dependencies:
```bash
composer install
```

### Chạy migrations:
```bash
php artisan migrate
```

### Tạo application key:
```bash
php artisan key:generate
```

### Khởi động server:
```bash
php artisan serve
```

## 4. Tính năng đã được thêm

### Google Authentication
- Đăng nhập bằng Google tại `/auth/google`
- Tự động tạo tài khoản mới hoặc đăng nhập vào tài khoản hiện có
- Lưu Google ID và avatar từ Google
- **Chỉ sử dụng Google, không có GitHub authentication**

### Email Verification
- Yêu cầu xác thực email khi đăng ký thủ công
- Trang xác thực email tại `/email/verify`
- Gửi lại email xác thực
- Middleware `verified` để bảo vệ các route quan trọng

### Newsletter Subscription
- Form đăng ký ở sidebar trang chủ (đã có sẵn, không tạo thêm)
- API endpoint: `POST /newsletter/subscribe`
- Gửi email chào mừng tự động
- Hỗ trợ hủy đăng ký

## 5. Sử dụng

### Đăng ký thủ công
1. Người dùng đăng ký tại `/register`
2. Nhận email xác thực
3. Click link trong email để xác thực
4. Có thể đăng bài và tương tác

### Đăng nhập Google
1. Click nút "Đăng nhập với Google"
2. Được chuyển đến Google OAuth
3. Cho phép ứng dụng truy cập
4. Tự động đăng nhập, email đã được verify

### Đăng ký Newsletter
1. Điền form newsletter ở sidebar trang chủ
2. Nhận email chào mừng
3. Được thêm vào danh sách gửi tin

## 6. Bảo mật

- Email verification bắt buộc cho đăng ký thủ công
- Google OAuth tự động verify email
- Middleware bảo vệ các chức năng quan trọng
- CSRF protection cho tất cả forms
- Rate limiting cho gửi email verification

## 7. Database Changes

### Users table đã thêm:
- `google_id` (string, nullable)
- `avatar` (string, nullable)  
- `role` enum: 'admin', 'user', 'subscriber'
- `password` có thể null (cho newsletter subscribers)

## 8. UI Changes

### Đã cập nhật:
- Xóa GitHub authentication khỏi trang login/register
- Chỉ giữ lại Google authentication
- Form newsletter ở trang chủ đã được tích hợp với backend
- Thêm JavaScript xử lý form newsletter

## 9. Troubleshooting

### Lỗi Google OAuth
- Kiểm tra Client ID/Secret
- Đảm bảo redirect URI chính xác
- Kích hoạt Google+ API

### Email không gửi được
- Kiểm tra cấu hình SMTP
- Đảm bảo App Password được tạo đúng (Gmail)
- Kiểm tra firewall/antivirus

### Database errors
- Chạy `php artisan migrate:fresh` nếu cần
- Kiểm tra quyền ghi database file (SQLite)
