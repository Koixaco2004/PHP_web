<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        // Statistics data
        $total_posts = Post::count();
        $published_posts = Post::where('status', 'published')->count();
        $draft_posts = Post::where('status', 'draft')->count();
        $pending_comments = Comment::where('is_approved', false)->count();
        $total_users = User::count();
        
        // Additional stats for sidebar
        $today_posts = Post::whereDate('created_at', today())->count();
        $week_posts = Post::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $today_comments = Comment::whereDate('created_at', today())->count();
        $today_views = 0; // Placeholder - implement view tracking later
        $active_categories = Category::where('is_active', true)->count();
        $active_users = User::whereDate('updated_at', '>=', now()->subDays(30))->count();

        // Recent content
        $recent_posts = Post::with(['category', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        $comments_pending = Comment::with(['user', 'post'])
            ->where('is_approved', false)
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'total_posts', 
            'published_posts', 
            'draft_posts', 
            'pending_comments', 
            'total_users',
            'today_posts',
            'week_posts', 
            'today_comments', 
            'today_views', 
            'active_categories', 
            'active_users',
            'recent_posts', 
            'comments_pending'
        ));
    }
}
