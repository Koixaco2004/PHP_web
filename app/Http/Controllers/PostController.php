<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'views':
                $query->orderBy('view_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }
        
        $posts = $query->paginate(15);
        $categories = Category::active()->get();
        
        return view('posts.index', compact('posts', 'categories'));
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
        ]);

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('posts.show', $post->slug)->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa thành công!');
    }
    
    /**
     * Handle bulk actions for posts
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,draft,delete',
            'posts' => 'required|array|min:1',
            'posts.*' => 'exists:posts,id'
        ]);
        
        $postIds = json_decode($request->posts, true);
        $action = $request->action;
        
        try {
            switch ($action) {
                case 'publish':
                    Post::whereIn('id', $postIds)->update(['status' => 'published']);
                    $message = 'Đã xuất bản ' . count($postIds) . ' bài viết thành công!';
                    break;
                    
                case 'draft':
                    Post::whereIn('id', $postIds)->update(['status' => 'draft']);
                    $message = 'Đã chuyển ' . count($postIds) . ' bài viết về trạng thái nháp!';
                    break;
                    
                case 'delete':
                    Post::whereIn('id', $postIds)->delete();
                    $message = 'Đã xóa ' . count($postIds) . ' bài viết thành công!';
                    break;
            }
            
            return response()->json(['success' => true, 'message' => $message]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Change post status
     */
    public function changeStatus(Post $post, Request $request)
    {
        $request->validate([
            'status' => 'required|in:draft,published,archived'
        ]);
        
        $post->update(['status' => $request->status]);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Duplicate a post
     */
    public function duplicate(Post $post)
    {
        $newPost = $post->replicate();
        $newPost->title = $post->title . ' (Copy)';
        $newPost->slug = Str::slug($newPost->title);
        $newPost->status = 'draft';
        $newPost->view_count = 0;
        $newPost->save();
        
        return response()->json(['success' => true, 'message' => 'Đã nhân bản bài viết thành công!']);
    }
}
