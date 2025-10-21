<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

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

        Comment::create([
            'content' => $request->content,
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'is_approved' => true, // Auto-approve all comments
        ]);

        return back()->with('success', 'Bình luận đã được đăng thành công!');
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

    /**
     * Approve a comment.
     */
    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Bình luận đã được phê duyệt!');
    }
}
