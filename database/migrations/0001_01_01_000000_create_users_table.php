<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo các bảng cơ sở dữ liệu cho hệ thống người dùng
     * Bao gồm bảng users, password_reset_tokens và sessions
     */
    public function up(): void
    {
        // Bảng users lưu trữ thông tin tài khoản và hồ sơ người dùng
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // Cho phép đăng nhập qua mạng xã hội
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('profile_views')->default(0);
            $table->rememberToken();
            $table->timestamps();

            // Tạo index để tăng tốc độ truy vấn theo role và google_id
            $table->index('role');
            $table->index('google_id');
        });

        // Bảng quản lý token để đặt lại mật khẩu
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Bảng lưu trữ phiên làm việc của người dùng
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Xóa các bảng cơ sở dữ liệu khi rollback migration
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
