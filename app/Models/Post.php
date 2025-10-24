<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'category_id',
        'user_id',
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
    ];

    /**
     * Get the category that owns the post.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get only published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Get posts by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Search posts by keyword.
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
     * Get the images for the post.
     */
    public function images()
    {
        return $this->hasMany(PostImage::class)->ordered();
    }

    /**
     * Get the featured image for the post.
     */
    public function featuredImage()
    {
        return $this->hasOne(PostImage::class)->where('is_featured', true);
    }

    /**
     * Get the first image as featured if no featured image is set.
     */
    public function getMainImageAttribute()
    {
        $featured = $this->featuredImage;
        if ($featured) {
            return $featured->image_url;
        }

        $firstImage = $this->images()->first();
        return $firstImage ? $firstImage->image_url : null;
    }

    /**
     * Get featured posts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the HTML version of the content (Markdown converted to HTML).
     */
    public function getContentHtmlAttribute()
    {
        // Check if content is already HTML (contains HTML tags)
        if (preg_match('/<[^>]+>/', $this->attributes['content'])) {
            return $this->attributes['content'];
        }

        // Otherwise, convert markdown to HTML
        return Str::markdown($this->attributes['content']);
    }

    /**
     * Get the HTML version of the excerpt (Markdown converted to HTML).
     */
    public function getExcerptHtmlAttribute()
    {
        return $this->attributes['excerpt'] ? Str::markdown($this->attributes['excerpt']) : '';
    }

    /**
     * Scope to get posts only from active categories.
     */
    public function scopeWithActiveCategory($query)
    {
        return $query->whereHas('category', function ($q) {
            $q->where('is_active', true);
        });
    }
}
