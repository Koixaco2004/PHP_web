<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

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
        $post = Post::with(['category', 'user', 'comments.user'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Tăng lượt xem
        $post->increment('view_count');

        // Lấy bài viết liên quan
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
