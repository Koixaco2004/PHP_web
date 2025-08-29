<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['category', 'user'])->latest()->paginate(10);
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
            'featured_image' => 'nullable|url',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        // Handle uploaded images
        if ($request->uploaded_images) {
            $uploadedImages = json_decode($request->uploaded_images, true);
            $featuredImageUrl = $request->featured_image;
            
            foreach ($uploadedImages as $index => $imageData) {
                PostImage::create([
                    'post_id' => $post->id,
                    'image_url' => $imageData['image_url'],
                    'delete_url' => $imageData['delete_url'] ?? null,
                    'width' => $imageData['width'] ?? null,
                    'height' => $imageData['height'] ?? null,
                    'file_size' => $imageData['file_size'] ?? null,
                    'sort_order' => $index,
                    'is_featured' => $imageData['image_url'] === $featuredImageUrl,
                ]);
            }
        }

        return redirect()->route('posts.show', $post->slug)->with('success', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['category', 'user', 'comments.user']);
        $post->increment('view_count');
        
        $relatedPosts = Post::with(['category', 'user'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->published()
            ->latest()
            ->limit(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
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
            'featured_image' => 'nullable|url',
        ]);

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'featured_image' => $request->featured_image,
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
                foreach ($uploadedImages as $imageData) {
                    $post->images()->create([
                        'image_url' => $imageData['image_url'],
                        'alt_text' => $imageData['alt_text'] ?? '',
                        'is_featured' => ($imageData['image_url'] === $request->featured_image),
                    ]);
                }
            }
        }

        // Update featured image status for existing images
        if ($request->featured_image) {
            // Reset all images to not featured
            $post->images()->update(['is_featured' => false]);
            
            // Set the selected image as featured
            $post->images()->where('image_url', $request->featured_image)
                ->update(['is_featured' => true]);
        }

        return redirect()->route('posts.show', $post->slug)->with('success', 'Bài viết đã được cập nhật thành công!');
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
