<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng notifications để lưu trữ thông báo cho người dùng.
     * 
     * Bảng này sử dụng UUID làm khóa chính và hỗ trợ polymorphic relationship
     * để gắn thông báo với nhiều loại model khác nhau.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            // UUID làm định danh duy nhất cho mỗi thông báo
            $table->uuid('id')->primary();

            // Loại thông báo (ví dụ: 'OrderShipped', 'CommentReply')
            $table->string('type');

            // Polymorphic relationship: liên kết thông báo tới model khác nhau
            // Tạo cặp cột 'notifiable_type' và 'notifiable_id'
            $table->morphs('notifiable');

            // Dữ liệu thông báo được lưu dưới dạng JSON
            $table->text('data');

            // Thời điểm người dùng đọc thông báo (null nếu chưa đọc)
            $table->timestamp('read_at')->nullable();

            // Timestamp tự động: created_at, updated_at
            $table->timestamps();
        });
    }

    /**
     * Xóa bảng notifications khi rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
