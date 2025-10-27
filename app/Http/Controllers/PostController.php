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
     * Hiển thị danh sách bài viết.
     */
    public function index()
    {
        $posts = Post::with(['category', 'user', 'images' => function ($query) {
            $query->where('is_featured', true)->orWhere('sort_order', 0);
        }])->withActiveCategory()->latest()->paginate(10);

        // Lấy thống kê tổng hợp (phù hợp với logic dashboard)
        $totalPosts = Post::count();
        $publishedPosts = Post::where('approval_status', 'approved')->count();
        $pendingPosts = Post::where('approval_status', 'pending')->count();
        $totalViews = Post::sum('view_count');

        return view('posts.index', compact('posts', 'totalPosts', 'publishedPosts', 'pendingPosts', 'totalViews'));
    }

    /**
     * Hiển thị form tạo bài viết mới.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Lưu bài viết mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|max:500',
            'uploaded_images' => 'nullable|json',
        ]);

        // Xác định trạng thái phê duyệt dựa trên vai trò người dùng
        $isAdmin = Auth::user()->role === 'admin';
        $approvalStatus = $isAdmin ? 'approved' : 'pending';
        $approvedBy = $isAdmin ? Auth::id() : null;
        $approvedAt = $isAdmin ? now() : null;

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'approval_status' => $approvalStatus,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'published_at' => now(),
            'approved_by' => $approvedBy,
            'approved_at' => $approvedAt,
        ]);

        // Xử lý hình ảnh đã tải lên
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

        // Gửi thông báo cho admin nếu bài viết cần phê duyệt
        if ($post->approval_status === 'pending') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewPostPendingNotification($post));
            }
        }

        // Xác định thông điệp dựa trên trạng thái phê duyệt
        $message = $isAdmin
            ? 'Bài viết đã được đăng thành công!'
            : 'Bài viết đã được gửi đến admin để phê duyệt!';

        return redirect()->route('posts.show', $post->slug)->with('success', $message);
    }

    /**
     * Hiển thị form chỉnh sửa bài viết.
     */
    public function edit(Post $post)
    {
        // Check if user can edit this post (author or admin)
        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền chỉnh sửa bài viết này.');
        }

        $categories = Category::active()->get();

        // Tải hình ảnh và loại bỏ trùng lặp theo URL, cũng tải số lượng bình luận
        $post->loadCount('comments');
        $post->load('images');
        $uniqueImages = $post->images->unique('image_url');
        $post->setRelation('images', $uniqueImages);

        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Cập nhật bài viết được chỉ định.
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
            'uploaded_images' => 'nullable|json',
            'deleted_images' => 'nullable|json',
        ]);

        // Tạo slug mới nếu tiêu đề thay đổi
        if ($post->title !== $request->title) {
            $newSlug = Str::slug($request->title);

            // Nếu slug trống, tạo fallback
            if (empty($newSlug)) {
                $newSlug = 'post-' . time();
            }

            // Đảm bảo slug duy nhất
            $originalSlug = $newSlug;
            $counter = 1;
            while (Post::where('slug', $newSlug)->where('id', '!=', $post->id)->exists()) {
                $newSlug = $originalSlug . '-' . $counter;
                $counter++;
            }
        } else {
            $newSlug = $post->slug;
        }

        // Xác định trạng thái phê duyệt dựa trên vai trò người dùng
        $isAdmin = Auth::user()->role === 'admin';
        $oldApprovalStatus = $post->approval_status; // Lưu trạng thái cũ
        $approvalStatus = $isAdmin ? 'approved' : 'pending';

        $post->update([
            'title' => $request->title,
            'slug' => $newSlug,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'category_id' => $request->category_id,
            'updated_by' => Auth::id(),
            'approval_status' => $approvalStatus,
            'published_at' => !$post->published_at ? now() : $post->published_at,
            'approved_by' => $isAdmin ? Auth::id() : $post->approved_by,
            'approved_at' => $isAdmin ? now() : $post->approved_at,
        ]);

        // Xử lý hình ảnh đã xóa
        if ($request->deleted_images) {
            $deletedImages = json_decode($request->deleted_images, true);
            if (is_array($deletedImages)) {
                foreach ($deletedImages as $imageUrl) {
                    $post->images()->where('image_url', $imageUrl)->delete();
                }
            }
        }

        // Xử lý hình ảnh mới đã tải lên
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

        // Gửi thông báo cho admin nếu bài viết chuyển sang trạng thái pending (từ rejected)
        if (!$isAdmin && $approvalStatus === 'pending' && $oldApprovalStatus !== 'pending') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewPostPendingNotification($post));
            }
        }

        // Làm mới bài viết để lấy slug cập nhật
        $post->refresh();

        // Xác định thông điệp dựa trên trạng thái phê duyệt
        $message = $isAdmin
            ? 'Bài viết được đăng thành công!'
            : 'Bài viết đã được cập nhật và gửi đến admin để phê duyệt lại!';

        // Logic chuyển hướng: Nếu phê duyệt, hiển thị; nếu chờ, chỉnh sửa
        if ($post->approval_status === 'approved') {
            return redirect()->route('posts.show', $post->slug)->with('success', $message);
        } else {
            // For pending approval, redirect to edit to avoid 404
            return redirect()->route('posts.edit', $post)->with('success', $message);
        }
    }

    /**
     * Xóa bài viết được chỉ định.
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
     * Tải lên hình ảnh cho trình chỉnh sửa TinyMCE.
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
            Log::error('Lỗi tải lên hình ảnh TinyMCE: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi upload ảnh: ' . $e->getMessage()
            ], 500);
        }
    }
}
