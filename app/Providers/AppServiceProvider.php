<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Category;

/**
 * Nhà cung cấp dịch vụ ứng dụng - Cấu hình các dịch vụ chung của ứng dụng.
 * Chịu trách nhiệm khởi tạo cài đặt toàn cục như phân trang, dữ liệu được chia sẻ giữa các view.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Đăng ký các dịch vụ ứng dụng.
     * Được gọi khi ứng dụng khởi động, trước khi các dịch vụ khác được khởi động.
     */
    public function register(): void
    {
        //
    }

    /**
     * Khởi động các dịch vụ ứng dụng.
     * Được gọi sau khi tất cả dịch vụ đã được đăng ký, dùng để cấu hình và khởi tạo các tính năng.
     */
    public function boot(): void
    {
        // Sử dụng giao diện phân trang tùy chỉnh với Tailwind CSS
        Paginator::defaultView('vendor.pagination.tailwind');

        // Chia sẻ danh mục (chỉ những danh mục hoạt động) với các view chỉ định
        // Thực hiện truy vấn này để lấy số lượng bài viết đã được phê duyệt cho mỗi danh mục,
        // từ đó hỗ trợ hiển thị tính toán động trong thanh điều hướng
        View::composer(['layouts.app', 'home', 'posts.*'], function ($view) {
            $navigationCategories = Category::active()
                ->withCount(['posts' => function ($query) {
                    $query->published();
                }])
                ->ordered()
                ->get();
            $view->with('navigationCategories', $navigationCategories);
        });
    }
}
