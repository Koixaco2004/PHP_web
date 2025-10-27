<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo bảng lưu trữ bài viết với các trường thông tin bài viết, trạng thái phê duyệt,
     * và các chỉ mục để tối ưu hiệu suất truy vấn
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('excerpt')->nullable();

            // Trạng thái phê duyệt bài viết
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();

            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            $table->integer('view_count')->unsigned()->default(0);
            $table->integer('comment_count')->unsigned()->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Chỉ mục để tối ưu hiệu suất truy vấn
            $table->index('published_at');
            $table->index('approval_status');
            $table->index('category_id');
            $table->index('user_id');
            $table->index('is_featured');
            $table->fullText(['title', 'excerpt']);
        });
    }

    /**
     * Rollback migration - xóa bảng posts
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
