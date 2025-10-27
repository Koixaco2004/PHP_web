<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Comment
 * 
 * Đại diện cho một bình luận trong hệ thống, hỗ trợ cấu trúc phân cấp (bình luận và phản hồi)
 * và khả năng phát hiện nội dung có độc hại.
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'post_id',
        'user_id',
        'parent_id',
        'is_toxic',
    ];

    protected $casts = [
        'is_toxic' => 'boolean',
    ];

    /**
     * Lấy bài viết sở hữu bình luận
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Lấy người dùng sở hữu bình luận
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy bình luận cha (dùng cho phản hồi bình luận)
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Lấy tất cả bình luận con (phản hồi)
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Lấy chỉ các bình luận cấp cao nhất (không có cha)
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Tính độ sâu của bình luận trong cấu trúc phân cấp
     * 
     * Độ sâu được xác định bằng số lần phải đi lên cây để đạt bình luận gốc.
     * Ví dụ: bình luận gốc có độ sâu = 0, phản hồi trực tiếp = 1, v.v.
     */
    public function getDepthAttribute()
    {
        $depth = 0;
        $parent = $this->parent;

        // Lặp lên cây bình luận để đếm số cấp độ
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }
}
