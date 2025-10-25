<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewCommentNotification;
use App\Notifications\NewReplyNotification;

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
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
        ]);

        if ($request->parent_id) {
            $parentComment = Comment::find($request->parent_id);
            if ($parentComment && $parentComment->user_id !== Auth::id()) {
                $parentComment->user->notify(new NewReplyNotification($comment, $post));
            }
        } else {
            if ($post->user_id !== Auth::id()) {
                $post->user->notify(new NewCommentNotification($post, $comment));
            }
        }

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
}