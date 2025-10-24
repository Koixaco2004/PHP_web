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
     * Display the home page.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user', 'images'])->published()->withActiveCategory();

        // Lọc theo chuyên mục (chỉ giữ lại filter cơ bản cho trang chủ)
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $posts = $query->orderBy('approved_at', 'desc')->paginate(9);
        $categories = Category::active()->get();

        return view('home', compact('posts', 'categories'));
    }

    /**
     * Display the specified post.
     */
    public function show($slug)
    {
        $query = Post::with(['category', 'user', 'comments' => function ($q) {
            $q->with('user')->whereNull('parent_id');
        }, 'images'])->where('slug', $slug);

        // If user is authenticated and is admin or author, show all posts
        if (Auth::check()) {
            $user = Auth::user();
            $post = $query->firstOrFail();

            // Check if user is admin or the author of the post
            if ($user->role !== 'admin' && $post->user_id !== $user->id) {
                // For regular users who are not the author, only show published and approved posts
                if ($post->status !== 'published' || $post->approval_status !== 'approved') {
                    abort(404);
                }
            }
        } else {
            // For public users, only show published and approved posts
            $post = $query->published()->firstOrFail();
        }

        // Remove duplicate images by URL
        if ($post->images) {
            $uniqueImages = $post->images->unique('image_url');
            $post->setRelation('images', $uniqueImages);
        }

        // Only increment view count for published and approved posts
        if ($post->status === 'published' && $post->approval_status === 'approved') {
            $post->increment('view_count');
        }

        // Lấy bài viết liên quan sử dụng SearchService
        $relatedPosts = $this->searchService->getRelatedPosts($post, 3);

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
