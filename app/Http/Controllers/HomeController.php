<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user', 'images'])->published();

        // Tìm kiếm theo từ khóa
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Lọc theo chuyên mục
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
            $q->with('user')->where('is_approved', true)->whereNull('parent_id');
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

        // Lấy bài viết liên quan (chỉ published)
        $relatedPosts = Post::with(['category', 'user'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->published()
            ->latest()
            ->limit(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
