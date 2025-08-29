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
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('image_url'); // URL từ ImgBB hoặc storage
            $table->string('delete_url')->nullable(); // URL để xóa ảnh từ ImgBB
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->integer('file_size')->nullable(); // Size in bytes
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['post_id', 'sort_order']);
            $table->index(['post_id', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};
