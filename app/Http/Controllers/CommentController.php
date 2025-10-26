<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewCommentNotification;
use App\Notifications\NewReplyNotification;
use App\Services\ToxicCommentService;

class CommentController extends Controller
{
    use AuthorizesRequests;

    protected ToxicCommentService $toxicCommentService;

    public function __construct(ToxicCommentService $toxicCommentService)
    {
        $this->toxicCommentService = $toxicCommentService;
    }

    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        // Check if the comment is toxic using AI
        $isToxic = $this->toxicCommentService->isToxic($request->content);

        $comment = Comment::create([
            'content' => $request->content,
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'is_toxic' => $isToxic,
        ]);

        // Load relationships for the response
        $comment->load('user', 'children.user');

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

        // Check if it's an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            // Return different views based on whether it's a reply or parent comment
            $view = $request->parent_id ? 'partials.reply' : 'partials.comment';
            $data = $request->parent_id ? ['reply' => $comment, 'post' => $post] : ['comment' => $comment, 'post' => $post];

            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được đăng thành công!',
                'comment' => $comment,
                'html' => view($view, $data)->render()
            ]);
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
