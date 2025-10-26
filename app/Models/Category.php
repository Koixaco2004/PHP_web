<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Mô hình Category - Quản lý các chuyên mục bài viết.
 * 
 * Cung cấp các chức năng lọc, sắp xếp chuyên mục và lấy thông tin bài viết liên quan.
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Lấy danh sách bài viết thuộc chuyên mục này.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Scope lọc chỉ các chuyên mục đang hoạt động.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope sắp xếp chuyên mục theo thứ tự ưu tiên, sau đó theo tên.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Lấy số lượng bài viết đã xuất bản trong chuyên mục này.
     */
    public function getPostsCountAttribute()
    {
        return $this->posts()->published()->count();
    }
}
