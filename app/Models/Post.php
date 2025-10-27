<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Model Post - Quản lý bài viết và các mối quan hệ liên quan
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'approval_status',
        'rejection_reason',
        'category_id',
        'user_id',
        'created_by',
        'updated_by',
        'approved_by',
        'approved_at',
        'view_count',
        'comment_count',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'view_count' => 'integer',
        'comment_count' => 'integer',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Lấy chuyên mục sở hữu bài viết
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Lấy người dùng sở hữu bài viết
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy người dùng đã tạo bài viết
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Lấy người dùng đã cập nhật bài viết lần cuối
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Lấy admin đã phê duyệt bài viết
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Lấy bình luận cho bài viết
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Lọc bài viết đã được phê duyệt và công khai
     */
    public function scopePublished($query)
    {
        return $query->where('approval_status', 'approved')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Lọc bài viết đang chờ phê duyệt
     */
    public function scopePendingApproval($query)
    {
        return $query->where('approval_status', 'pending');
    }

    /**
     * Lọc bài viết đã phê duyệt
     */
    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    /**
     * Lọc bài viết bị từ chối
     */
    public function scopeRejected($query)
    {
        return $query->where('approval_status', 'rejected');
    }

    /**
     * Lọc bài viết theo chuyên mục
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Tìm kiếm bài viết theo từ khóa trong tiêu đề, nội dung hoặc tóm tắt
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('content', 'like', "%{$keyword}%")
                ->orWhere('excerpt', 'like', "%{$keyword}%");
        });
    }

    /**
     * Lấy tất cả hình ảnh của bài viết (theo thứ tự)
     */
    public function images()
    {
        return $this->hasMany(PostImage::class)->ordered();
    }

    /**
     * Lấy hình ảnh được đặt làm nổi bật của bài viết
     */
    public function featuredImage()
    {
        return $this->hasOne(PostImage::class)->where('is_featured', true);
    }

    /**
     * Lấy hình ảnh chính (ưu tiên nổi bật, nếu không có lấy hình đầu tiên)
     */
    public function getMainImageAttribute()
    {
        $featured = $this->featuredImage;
        if ($featured) {
            return $featured->image_url;
        }

        // Fallback lấy hình ảnh đầu tiên nếu không có hình ảnh nổi bật
        $firstImage = $this->images()->first();
        return $firstImage ? $firstImage->image_url : null;
    }

    /**
     * Lọc bài viết được đánh dấu nổi bật
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Lấy nội dung dưới dạng HTML (tự động chuyển đổi Markdown nếu cần)
     */
    public function getContentHtmlAttribute()
    {
        // Kiểm tra nếu nội dung đã là HTML, nếu không thì chuyển đổi từ Markdown
        if (preg_match('/<[^>]+>/', $this->attributes['content'])) {
            return $this->attributes['content'];
        }

        return Str::markdown($this->attributes['content']);
    }

    /**
     * Lấy tóm tắt dưới dạng HTML (chuyển đổi từ Markdown)
     */
    public function getExcerptHtmlAttribute()
    {
        return $this->attributes['excerpt'] ? Str::markdown($this->attributes['excerpt']) : '';
    }

    /**
     * Lọc bài viết chỉ từ chuyên mục đang hoạt động
     */
    public function scopeWithActiveCategory($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('is_active', true);
        });
    }
}
