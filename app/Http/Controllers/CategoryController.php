<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách chuyên mục.
     */
    public function index()
    {
        $categories = Category::withCount('posts')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Hiển thị form tạo chuyên mục mới.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Lưu chuyên mục mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('categories.index')->with('success', 'Chuyên mục đã được tạo thành công!');
    }

    /**
     * Hiển thị chuyên mục được chỉ định.
     */
    public function show(Category $category)
    {
        $posts = $category->posts()
            ->with(['user', 'images' => function ($query) {
                $query->where('is_featured', true)->orWhere('sort_order', 0);
            }])
            ->published()
            ->latest()
            ->paginate(10);
        return view('categories.show', compact('category', 'posts'));
    }

    /**
     * Hiển thị form chỉnh sửa chuyên mục.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Cập nhật chuyên mục được chỉ định.
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
     * Xóa chuyên mục được chỉ định.
     */
    public function destroy(Category $category)
    {
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Không thể xóa chuyên mục có bài viết!');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Chuyên mục đã được xóa thành công!');
    }
}
