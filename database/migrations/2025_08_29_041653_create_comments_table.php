<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng comments để lưu trữ bình luận của người dùng.
     * Hỗ trợ bình luận lồng nhau (reply) và phát hiện nội dung độc hại.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Cho phép null để hỗ trợ bình luận gốc, không null thì là reply
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->boolean('is_toxic')->default(false);
            $table->timestamps();

            // Indexes để tối ưu các truy vấn thường xuyên
            $table->index(['post_id', 'created_at']);
            $table->index(['parent_id']);
            $table->index(['user_id']);
        });
    }

    /**
     * Xóa bảng comments khi rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
