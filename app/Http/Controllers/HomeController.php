<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    /**
     * Hiển thị trang chủ.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user', 'images'])->published()->withActiveCategory();

        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $posts = $query->orderBy('approved_at', 'desc')->paginate(9);
        $categories = Category::active()->get();

        return view('home', compact('posts', 'categories'));
    }

    /**
     * Hiển thị bài viết được chỉ định.
     */
    public function show($slug)
    {
        $query = Post::with(['category', 'user', 'comments' => function ($q) {
            $q->with('user', 'children.user')->whereNull('parent_id')->latest();
        }, 'images'])->where('slug', $slug);

        // Nếu người dùng đã xác thực, kiểm tra quyền
        if (Auth::check()) {
            $user = Auth::user();
            $post = $query->firstOrFail();

            // Bài viết nháp chỉ có thể xem bởi tác giả
            if ($post->status === 'draft' && $post->user_id !== $user->id) {
                abort(404);
            }

            // Đối với bài viết đã xuất bản, kiểm tra nếu người dùng là tác giả hoặc bài viết đã được phê duyệt
            if ($post->status === 'published') {
                if ($post->approval_status !== 'approved' && $post->user_id !== $user->id) {
                    // Non-authors can only see approved published posts
                    abort(404);
                }
            }
        } else {
            // Đối với người dùng công khai, chỉ hiển thị bài viết đã xuất bản và phê duyệt
            $post = $query->published()->firstOrFail();
        }

        // Loại bỏ hình ảnh trùng lặp theo URL
        if ($post->images) {
            $uniqueImages = $post->images->unique('image_url');
            $post->setRelation('images', $uniqueImages);
        }

        // Chỉ tăng số lượt xem cho bài viết đã xuất bản và phê duyệt
        if ($post->status === 'published' && $post->approval_status === 'approved') {
            $post->increment('view_count');
        }

        // Lấy bài viết liên quan bằng SearchService
        $relatedPosts = $this->searchService->getRelatedPosts($post, 3);

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
