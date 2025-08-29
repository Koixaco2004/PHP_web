<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use App\Services\ImgBBService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostImageController extends Controller
{
    protected $imgBBService;

    public function __construct(ImgBBService $imgBBService)
    {
        $this->imgBBService = $imgBBService;
    }

    /**
     * Upload multiple images for a post
     */
    public function store(Request $request, Post $post): JsonResponse
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        $uploadedImages = [];
        $errors = [];

        foreach ($request->file('images') as $index => $file) {
            $result = $this->imgBBService->uploadImage($file);
            
            if ($result['success']) {
                $image = PostImage::create([
                    'post_id' => $post->id,
                    'image_url' => $result['data']['image_url'],
                    'delete_url' => $result['data']['delete_url'],
                    'width' => $result['data']['width'],
                    'height' => $result['data']['height'],
                    'file_size' => $result['data']['file_size'],
                    'sort_order' => $index,
                    'is_featured' => $index === 0 && !$post->images()->where('is_featured', true)->exists(),
                ]);
                
                $uploadedImages[] = $image;
            } else {
                $errors[] = "Failed to upload image: " . $file->getClientOriginalName();
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($uploadedImages) . ' images uploaded successfully',
            'images' => $uploadedImages,
            'errors' => $errors
        ]);
    }

    /**
     * Update image details
     */
    public function update(Request $request, PostImage $image): JsonResponse
    {
        $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
        ]);

        // If setting as featured, remove featured from other images of the same post
        if ($request->is_featured) {
            PostImage::where('post_id', $image->post_id)
                ->where('id', '!=', $image->id)
                ->update(['is_featured' => false]);
        }

        $image->update($request->only(['alt_text', 'caption', 'sort_order', 'is_featured']));

        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully',
            'image' => $image
        ]);
    }

    /**
     * Delete an image
     */
    public function destroy(PostImage $image): JsonResponse
    {
        // Delete from ImgBB
        if ($image->delete_url) {
            $this->imgBBService->deleteImage($image->delete_url);
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

    /**
     * Get all images for a post
     */
    public function index(Post $post): JsonResponse
    {
        $images = $post->images()->ordered()->get();

        return response()->json([
            'success' => true,
            'images' => $images
        ]);
    }

    /**
     * Set featured image
     */
    public function setFeatured(PostImage $image): JsonResponse
    {
        // Remove featured from other images of the same post
        PostImage::where('post_id', $image->post_id)
            ->where('id', '!=', $image->id)
            ->update(['is_featured' => false]);

        $image->update(['is_featured' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Featured image updated successfully'
        ]);
    }
}
