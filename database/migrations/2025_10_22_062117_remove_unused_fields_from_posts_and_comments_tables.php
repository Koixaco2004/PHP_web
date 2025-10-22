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
        // Remove unused fields from posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['like_count', 'allow_comments', 'meta_data']);
            $table->enum('status', ['draft', 'published'])->default('draft')->change();
        });

        // Remove unused fields from comments table
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['like_count', 'meta_data']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore posts table fields
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('like_count')->unsigned()->default(0);
            $table->boolean('allow_comments')->default(true);
            $table->json('meta_data')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->change();
        });

        // Restore comments table fields
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('like_count')->unsigned()->default(0);
            $table->json('meta_data')->nullable();
        });
    }
};
