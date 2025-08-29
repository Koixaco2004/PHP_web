<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'excerpt',
        'image_url',
        'status',
        'category_id',
        'user_id',
        'view_count',
    ];

    protected $casts = [
        'view_count' => 'integer',
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
        return $query->where('status', 'published');
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
        return $query->where(function($q) use ($keyword) {
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
        return $firstImage ? $firstImage->image_url : $this->featured_image;
    }
}
