<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\Category;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['category', 'user', 'images' => function($query) {
            $query->where('is_featured', true)->orWhere('sort_order', 0);
        }])->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|max:500',
            'status' => 'required|in:draft,published',
            'uploaded_images' => 'nullable|json',
        ]);



        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        // Handle uploaded images
        if ($request->uploaded_images) {
            $uploadedImages = json_decode($request->uploaded_images, true);
            
            foreach ($uploadedImages as $index => $imageData) {
                PostImage::create([
                    'post_id' => $post->id,
                    'image_url' => $imageData['image_url'],
                    'delete_url' => $imageData['delete_url'] ?? null,
                    'alt_text' => $imageData['alt_text'] ?? null,
                    'caption' => $imageData['caption'] ?? null,
                    'width' => $imageData['width'] ?? null,
                    'height' => $imageData['height'] ?? null,
                    'file_size' => $imageData['file_size'] ?? null,
                    'sort_order' => $index,
                    'is_featured' => ($imageData['is_featured'] ?? false) || $index === 0, // First image is featured by default
                ]);
            }
        }

        $message = $post->status === 'published' 
            ? 'Bài viết đã được xuất bản thành công!' 
            : 'Bài viết đã được lưu làm bản nháp thành công!';
            
        return redirect()->route('posts.show', $post->slug)->with('success', $message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::active()->get();
        
        // Load images and remove duplicates by URL
        $post->load('images');
        $uniqueImages = $post->images->unique('image_url');
        $post->setRelation('images', $uniqueImages);
        
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|max:500',
            'status' => 'required|in:draft,published',
            'uploaded_images' => 'nullable|json',
            'deleted_images' => 'nullable|json',
        ]);

        // Generate new slug if title changed
        if ($post->title !== $request->title) {
            $newSlug = Str::slug($request->title);
            
            // If slug is empty, generate a fallback
            if (empty($newSlug)) {
                $newSlug = 'post-' . time();
            }
            
            // Ensure unique slug
            $originalSlug = $newSlug;
            $counter = 1;
            while (Post::where('slug', $newSlug)->where('id', '!=', $post->id)->exists()) {
                $newSlug = $originalSlug . '-' . $counter;
                $counter++;
            }
        } else {
            $newSlug = $post->slug;
        }

        $post->update([
            'title' => $request->title,
            'slug' => $newSlug,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'published_at' => $request->status === 'published' && !$post->published_at ? now() : ($request->status === 'draft' ? null : $post->published_at),
        ]);

        // Handle deleted images
        if ($request->deleted_images) {
            $deletedImages = json_decode($request->deleted_images, true);
            if (is_array($deletedImages)) {
                foreach ($deletedImages as $imageUrl) {
                    $post->images()->where('image_url', $imageUrl)->delete();
                }
            }
        }

        // Handle new uploaded images
        if ($request->uploaded_images) {
            $uploadedImages = json_decode($request->uploaded_images, true);
            if (is_array($uploadedImages)) {
                foreach ($uploadedImages as $index => $imageData) {
                    $post->images()->create([
                        'image_url' => $imageData['image_url'],
                        'delete_url' => $imageData['delete_url'] ?? null,
                        'alt_text' => $imageData['alt_text'] ?? '',
                        'caption' => $imageData['caption'] ?? null,
                        'sort_order' => $post->images()->count() + $index,
                        'is_featured' => $imageData['is_featured'] ?? false,
                        'width' => $imageData['width'] ?? null,
                        'height' => $imageData['height'] ?? null,
                        'file_size' => $imageData['file_size'] ?? null,
                    ]);
                }
            }
        }

        // Refresh post to get updated slug
        $post->refresh();
        
        $message = $post->status === 'published' 
            ? 'Bài viết đã được cập nhật và xuất bản thành công!' 
            : 'Bài viết đã được cập nhật và lưu làm bản nháp thành công!';
        
        // If post is draft, redirect to edit page instead of show page
        // because show page only displays published posts
        if ($post->status === 'draft') {
            return redirect()->route('posts.edit', $post)->with('success', $message);
        }
        
        // For published posts, redirect to show page
        return redirect()->route('posts.show', $post->slug)->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa thành công!');
    }
}