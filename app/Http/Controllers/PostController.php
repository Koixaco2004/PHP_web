<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\Category;
use App\Models\User;
use App\Services\SearchService;
use App\Notifications\NewPostPendingNotification;
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
        $posts = Post::with(['category', 'user', 'images' => function ($query) {
            $query->where('is_featured', true)->orWhere('sort_order', 0);
        }])->where('status', 'published')->withActiveCategory()->latest()->paginate(10);

        // Get total statistics (matching dashboard logic)
        $totalPosts = Post::where('status', 'published')->count();
        $publishedPosts = Post::where('status', 'published')->where('approval_status', 'approved')->count();
        $pendingPosts = Post::where('status', 'published')->where('approval_status', 'pending')->count();
        $totalViews = Post::where('status', 'published')->sum('view_count');

        return view('posts.index', compact('posts', 'totalPosts', 'publishedPosts', 'pendingPosts', 'totalViews'));
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
            'approval_status' => $request->status === 'published' ? 'pending' : 'pending',
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
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
                    'sort_order' => $index,
                    'is_featured' => ($imageData['is_featured'] ?? false) || $index === 0, // First image is featured by default
                ]);
            }
        }

        // Gửi thông báo cho admin nếu bài viết được publish và cần phê duyệt
        if ($post->status === 'published' && $post->approval_status === 'pending') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewPostPendingNotification($post));
            }
        }

        $message = $post->status === 'published'
            ? 'Bài viết đã được gửi đến admin để phê duyệt!'
            : 'Bài viết đã được lưu làm bản nháp thành công!';

        return redirect()->route('posts.show', $post->slug)->with('success', $message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // Check if user can edit this post (author or admin)
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền chỉnh sửa bài viết này.');
        }

        $categories = Category::active()->get();

        // Load images and remove duplicates by URL, also load comments count
        $post->loadCount('comments');
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
        // Check if user can update this post (author or admin)
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền cập nhật bài viết này.');
        }

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

        // Determine approval status based on user role
        $isAdmin = Auth::user()->role === 'admin';
        $oldApprovalStatus = $post->approval_status; // Lưu trạng thái cũ
        $approvalStatus = $request->status === 'published'
            ? ($isAdmin ? 'approved' : 'pending')
            : $post->approval_status;

        $post->update([
            'title' => $request->title,
            'slug' => $newSlug,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'updated_by' => Auth::id(),
            'approval_status' => $approvalStatus,
            'published_at' => $request->status === 'published' && !$post->published_at ? now() : ($request->status === 'draft' ? null : $post->published_at),
            'approved_by' => $isAdmin && $request->status === 'published' ? Auth::id() : $post->approved_by,
            'approved_at' => $isAdmin && $request->status === 'published' ? now() : $post->approved_at,
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
                    ]);
                }
            }
        }

        // Gửi thông báo cho admin nếu bài viết chuyển sang trạng thái pending (từ rejected hoặc draft)
        if (!$isAdmin && $request->status === 'published' && $approvalStatus === 'pending' && $oldApprovalStatus !== 'pending') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewPostPendingNotification($post));
            }
        }

        // Refresh post to get updated slug
        $post->refresh();

        // Determine message based on approval status
        if ($post->status === 'published') {
            $message = $isAdmin
                ? 'Bài viết được đăng thành công!'
                : 'Bài viết đã được cập nhật và gửi đến admin để phê duyệt lại!';
        } else {
            $message = 'Bài viết đã được cập nhật và lưu làm bản nháp thành công!';
        }

        // Redirect logic: If draft, always edit; if published and approved, show; if published and pending, edit
        if ($post->status === 'draft') {
            return redirect()->route('posts.edit', $post)->with('success', $message);
        }

        if ($post->approval_status === 'approved') {
            return redirect()->route('posts.show', $post->slug)->with('success', $message);
        } else {
            // For pending approval, redirect to edit to avoid 404
            return redirect()->route('posts.edit', $post)->with('success', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // Check if user can delete this post (author or admin)
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xóa bài viết này.');
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa thành công!');
    }

    /**
     * Upload image for TinyMCE editor
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            ]);

            if ($request->hasFile('file')) {
                $image = $request->file('file');

                // Use ImgBB service
                if (config('services.imgbb.key')) {
                    $imgbbService = app(\App\Services\ImgBBService::class);
                    $result = $imgbbService->uploadImage($image);

                    if ($result['success']) {
                        return response()->json([
                            'success' => true,
                            'data' => [
                                'url' => $result['data']['image_url'],
                                'delete_url' => $result['data']['delete_url'] ?? null,
                            ]
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => $result['message'] ?? 'Upload thất bại'
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'ImgBB API key chưa được cấu hình'
                    ], 400);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy file'
            ], 400);
        } catch (\Exception $e) {
            Log::error('TinyMCE Image Upload Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi upload ảnh: ' . $e->getMessage()
            ], 500);
        }
    }
}
