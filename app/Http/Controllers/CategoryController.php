<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get categories with post count ordered by sort_order
        $categories = Category::withCount('posts')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics
        $totalCategories = Category::count();
        $activeCategories = Category::where('is_active', true)->count();
        $inactiveCategories = Category::where('is_active', false)->count();
        
        // Additional statistics
        $totalPosts = Post::count();
        $todayViews = 0; // Placeholder - implement view tracking
        $weekPosts = Post::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $newComments = Comment::whereDate('created_at', today())->count();
        $activeUsers = User::whereDate('updated_at', '>=', now()->subDays(30))->count();
        
        // Recent activities (placeholder data)
        $recentActivities = [
            ['icon' => 'plus-circle', 'description' => 'Danh mục mới được tạo', 'time' => '2 giờ trước'],
            ['icon' => 'pencil', 'description' => 'Cập nhật thứ tự danh mục', 'time' => '5 giờ trước'],
            ['icon' => 'eye', 'description' => 'Xem danh mục công nghệ', 'time' => '1 ngày trước'],
        ];
        
        return view('categories.index', compact(
            'categories', 
            'totalCategories', 
            'activeCategories', 
            'inactiveCategories',
            'totalPosts',
            'todayViews',
            'weekPosts',
            'newComments',
            'activeUsers',
            'recentActivities'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => true,
            'sort_order' => Category::max('sort_order') + 1,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Danh mục đã được tạo thành công!']);
        }

        return redirect()->route('categories.index')->with('success', 'Chuyên mục đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $posts = $category->posts()->with('user')->published()->latest()->paginate(10);
        return view('categories.show', compact('category', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Chuyên mục đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->posts()->count() > 0) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Không thể xóa danh mục có bài viết!']);
            }
            return back()->with('error', 'Không thể xóa chuyên mục có bài viết!');
        }

        $category->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Danh mục đã được xóa thành công!']);
        }
        
        return redirect()->route('categories.index')->with('success', 'Chuyên mục đã được xóa thành công!');
    }
    
    /**
     * Toggle category status
     */
    public function toggle(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Reorder categories
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:categories,id'
        ]);
        
        $order = json_decode($request->order, true);
        
        foreach ($order as $index => $categoryId) {
            Category::where('id', $categoryId)->update(['sort_order' => $index + 1]);
        }
        
        return response()->json(['success' => true, 'message' => 'Đã cập nhật thứ tự danh mục thành công!']);
    }
}
