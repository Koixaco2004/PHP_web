<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tạo các bảng cache và cache_locks để lưu trữ dữ liệu cache và khóa phiên làm việc.
     */
    public function up(): void
    {
        // Bảng cache lưu trữ các giá trị cache với khóa duy nhất và thời gian hết hạn
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        // Bảng cache_locks quản lý khóa độc quyền để tránh xung đột khi cập nhật cache
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });
    }

    /**
     * Xóa các bảng cache và cache_locks khi rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
