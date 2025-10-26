<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Mô hình PostImage - Đại diện cho hình ảnh của bài viết.
 * 
 * Quản lý thông tin hình ảnh liên kết với bài viết, bao gồm URL, 
 * văn bản thay thế, và thứ tự hiển thị.
 */
class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'image_url',
        'delete_url',
        'alt_text',
        'caption',
        'sort_order',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Lấy bài viết chứa hình ảnh này.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Lọc để lấy chỉ các hình ảnh được đánh dấu nổi bật.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Sắp xếp theo thứ tự hiển thị và thời gian tạo.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}
