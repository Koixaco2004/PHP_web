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
            $q->with('user', 'children.user')->whereNull('parent_id')->latest();
        }, 'images'])->where('slug', $slug);

        // If user is authenticated, check permissions
        if (Auth::check()) {
            $user = Auth::user();
            $post = $query->firstOrFail();

            // Draft posts can only be viewed by the author
            if ($post->status === 'draft' && $post->user_id !== $user->id) {
                abort(404);
            }

            // For published posts, check if user is author or if post is approved
            if ($post->status === 'published') {
                if ($post->approval_status !== 'approved' && $post->user_id !== $user->id) {
                    // Non-authors can only see approved published posts
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

        // Get related posts using SearchService
        $relatedPosts = $this->searchService->getRelatedPosts($post, 3);

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}