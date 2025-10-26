<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng lưu trữ hình ảnh của bài viết.
     * 
     * Bảng này quản lý tất cả hình ảnh liên kết với các bài viết,
     * bao gồm URL lưu trữ, metadata và thứ tự hiển thị.
     */
    public function up(): void
    {
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại tham chiếu đến bảng posts, tự động xóa khi bài viết bị xóa
            $table->foreignId('post_id')->constrained()->onDelete('cascade');

            $table->string('image_url'); // URL hình ảnh từ ImgBB hoặc storage
            $table->string('delete_url')->nullable(); // URL để xóa ảnh từ dịch vụ ImgBB
            $table->string('alt_text')->nullable(); // Văn bản thay thế cho hình ảnh
            $table->string('caption')->nullable(); // Mô tả hoặc tiêu đề của hình ảnh
            $table->integer('sort_order')->default(0); // Thứ tự hiển thị hình ảnh
            $table->boolean('is_featured')->default(false); // Đánh dấu hình ảnh chính
            $table->timestamps();

            // Các chỉ mục để tối ưu truy vấn theo bài viết và thứ tự
            $table->index(['post_id', 'sort_order']);
            $table->index(['post_id', 'is_featured']);
        });
    }

    /**
     * Xóa bảng post_images khi rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};
