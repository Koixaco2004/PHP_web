<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'content' => $request->content,
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'is_approved' => auth()->user()->isAdmin() ? true : false,
        ]);

        if (auth()->user()->isAdmin()) {
            return back()->with('success', 'Bình luận đã được đăng thành công!');
        } else {
            return back()->with('success', 'Bình luận đã được gửi và đang chờ phê duyệt!');
        }
    }

    /**
     * Approve a comment (admin only).
     */
    public function approve(Comment $comment)
    {
        $this->authorize('approve', $comment);
        
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Bình luận đã được phê duyệt!');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        return back()->with('success', 'Bình luận đã được xóa!');
    }
}
