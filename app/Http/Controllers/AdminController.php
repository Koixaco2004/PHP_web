<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;
use Carbon\Carbon;

class AdminController extends Controller
{
    use AuthorizesRequests;
    /**
     * Hiển thị bảng điều khiển quản trị.
     */
    public function dashboard(Request $request)
    {
        $months = $request->get('months', 6);

        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('approval_status', 'approved')->count(),
            'draft_posts' => 0, // Draft không còn tồn tại
            'pending_posts' => Post::where('approval_status', 'pending')->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'total_comments' => Comment::count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
        ];

        // Tính toán phần trăm thay đổi theo tháng cho tổng số bài viết
        $currentMonth = Carbon::now();
        $previousMonth = Carbon::now()->subMonth();

        $currentPosts = Post::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        $previousPosts = Post::whereMonth('created_at', $previousMonth->month)
            ->whereYear('created_at', $previousMonth->year)
            ->count();

        if ($previousPosts > 0) {
            $percentageChange = (($currentPosts - $previousPosts) / $previousPosts) * 100;
        } else {
            $percentageChange = $currentPosts > 0 ? 100 : 0; // If no previous posts, 100% if current > 0, else 0
        }

        $stats['posts_change_percentage'] = round($percentageChange, 1);

        // Chuẩn bị dữ liệu biểu đồ cho N tháng gần nhất
        $chartData = [];
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Post::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $chartData[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        // Hiển thị tất cả bài viết trong danh sách gần đây
        $recentPosts = Post::with(['category', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'chartData'));
    }

    /**
     * Hiển thị danh sách người dùng.
     */
    public function users()
    {
        $users = User::latest()->paginate(10);

        // Statistics for quick stats cards
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();
        $verifiedCount = User::whereNotNull('email_verified_at')->count();

        return view('admin.users.index', compact('users', 'adminCount', 'userCount', 'verifiedCount'));
    }

    /**
     * Hiển thị form chỉnh sửa người dùng.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật người dùng được chỉ định.
     */
    public function updateUser(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Vai trò đã được cập nhật thành công!']);
        }

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật!');
    }

    /**
     * Xóa người dùng được chỉ định.
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
     * Hiển thị danh sách bình luận.
     */
    public function comments()
    {
        $comments = Comment::with(['user', 'post'])->latest()->paginate(10);
        $totalCount = Comment::count();
        return view('admin.comments.index', compact('comments', 'totalCount'));
    }

    /**
     * Xóa bình luận được chỉ định.
     */
    public function destroyComment(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->back()->with('success', 'Bình luận đã được xóa!');
    }

    /**
     * Hiển thị bài viết đang chờ phê duyệt.
     */
    public function pendingPosts()
    {
        $pendingPosts = Post::with(['category', 'user'])
            ->pendingApproval()
            ->latest()
            ->paginate(10);

        return view('admin.posts.pending', compact('pendingPosts'));
    }

    /**
     * Phê duyệt bài viết.
     */
    public function approvePost(Post $post)
    {
        $post->update([
            'approval_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Gửi thông báo đến tác giả
        $post->user->notify(new PostApprovedNotification($post));

        return redirect()->back()->with('success', 'Bài viết đã được phê duyệt!');
    }

    /**
     * Từ chối bài viết.
     */
    public function rejectPost(Request $request, Post $post)
    {
        $validated = $request->validate([
            'rejection_reason_type' => 'required|string',
            'custom_rejection_reason' => 'nullable|string|max:1000',
        ]);

        $rejectionReason = $validated['rejection_reason_type'] === 'other'
            ? $validated['custom_rejection_reason']
            : $validated['rejection_reason_type'];

        $post->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $rejectionReason,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        $post->user->notify(new PostRejectedNotification($post));

        // Redirect về trang quản lý bài viết
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Bài viết đã bị từ chối!', 'redirect' => route('posts.index')]);
        }

        return redirect()->route('posts.index')->with('success', 'Bài viết đã bị từ chối!');
    }
}
