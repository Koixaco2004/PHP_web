<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Nhà cung cấp dịch vụ xác thực và phân quyền.
 * 
 * Quản lý các chính sách phân quyền cho các mô hình trong ứng dụng,
 * đảm bảo người dùng chỉ có thể thực hiện các hành động được phép.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Ánh xạ các mô hình tới chính sách phân quyền tương ứng.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Comment::class => CommentPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Đăng ký các dịch vụ xác thực và phân quyền.
     * 
     * Khởi tạo các cấu hình liên quan đến xác thực và phân quyền cho ứng dụng.
     */
    public function boot(): void
    {
        //
    }
}
