<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'total_comments' => Comment::count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
        ];

        $recentPosts = Post::with(['category', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts'));
    }

    /**
     * Display a listing of users.
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing a user.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function updateUser(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'role' => 'required|in:admin,user,subscriber',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    /**
     * Remove the specified user.
     */
    public function destroyUser(User $user)
    {
        $this->authorize('delete', $user);

        // Prevent deleting self
        if ($user->id === Auth::user()->id) {
            return redirect()->back()->with('error', 'Bạn không thể xóa tài khoản của chính mình!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa!');
    }

    /**
     * Display a listing of comments.
     */
    public function comments()
    {
        $comments = Comment::with(['user', 'post'])->latest()->paginate(10);
        $approvedCount = Comment::where('is_approved', true)->count();
        $pendingCount = Comment::where('is_approved', false)->count();
        return view('admin.comments.index', compact('comments', 'approvedCount', 'pendingCount'));
    }

    /**
     * Remove the specified comment.
     */
    public function destroyComment(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->back()->with('success', 'Bình luận đã được xóa!');
    }
}