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
        $query = Post::with(['category', 'user', 'images'])->published();

        // Lọc theo chuyên mục (chỉ giữ lại filter cơ bản cho trang chủ)
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        $posts = $query->latest()->paginate(10);
        $categories = Category::active()->get();

        return view('home', compact('posts', 'categories'));
    }

    /**
     * Display the specified post.
     */
    public function show($slug)
    {
        $query = Post::with(['category', 'user', 'comments' => function($q) {
            $q->with('user')->whereNull('parent_id');
        }])->where('slug', $slug);
        
        // If user is authenticated and is admin or author, show draft posts too
        if (Auth::check() && (Auth::user()->role === 'admin' || 
            $query->clone()->where('user_id', Auth::id())->exists())) {
            $post = $query->firstOrFail();
        } else {
            // For public users, only show published posts
            $post = $query->published()->firstOrFail();
        }

        // Only increment view count for published posts
        if ($post->status === 'published') {
            $post->increment('view_count');
        }

        // Lấy bài viết liên quan sử dụng SearchService
        $relatedPosts = $this->searchService->getRelatedPosts($post, 3);

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
