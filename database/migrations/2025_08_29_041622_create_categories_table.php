<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng categories để lưu trữ các danh mục sản phẩm
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            // Mặc định màu xanh lá để hiển thị trong giao diện người dùng
            $table->string('color', 7)->default('#22c55e');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Tạo chỉ mục để tối ưu hóa truy vấn theo trạng thái hoạt động và thứ tự sắp xếp
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Xóa bảng categories khi rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
