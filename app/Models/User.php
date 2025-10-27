<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Mô hình User - Quản lý dữ liệu người dùng và xác thực
 * 
 * Lớp này đại diện cho người dùng trong hệ thống, hỗ trợ xác thực,
 * quản lý hồ sơ, và tương tác với bài viết, bình luận.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'avatar',
        'bio',
        'location',
        'website',
        'phone',
        'date_of_birth',
        'profile_views',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Định nghĩa kiểu dữ liệu cho các thuộc tính
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'profile_views' => 'integer',
        ];
    }

    /**
     * Lấy danh sách bài viết của người dùng
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Lấy danh sách bình luận của người dùng
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Kiểm tra người dùng có quyền quản trị viên hay không
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Kiểm tra người dùng đã đăng nhập qua mạng xã hội chưa
     */
    public function hasSocialLogin()
    {
        return !empty($this->google_id);
    }

    /**
     * Tăng số lần xem hồ sơ người dùng
     */
    public function incrementProfileViews()
    {
        $this->increment('profile_views');
    }

    /**
     * Gửi thông báo đặt lại mật khẩu cho người dùng
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Gửi thông báo xác minh email cho người dùng
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new \App\Notifications\VerifyEmailNotification);
    }
}
