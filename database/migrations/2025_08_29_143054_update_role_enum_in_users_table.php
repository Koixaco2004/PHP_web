<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Thay đổi enum để thêm 'subscriber'
            $table->enum('role', ['admin', 'user', 'subscriber'])->default('user')->change();
            // Cho phép password có thể null (cho newsletter subscribers)
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Quay lại enum cũ
            $table->enum('role', ['admin', 'user'])->default('user')->change();
            // Yêu cầu password không được null
            $table->string('password')->nullable(false)->change();
        });
    }
};
