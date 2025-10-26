<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(DatabaseNotification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        // Determine redirect URL based on notification type
        $data = $notification->data;
        $redirectUrl = '/';

        if (isset($data['type'])) {
            switch ($data['type']) {
                case 'approved':
                    // Approved posts -> view post
                    $post = \App\Models\Post::find($data['post_id']);
                    $redirectUrl = $post ? route('posts.show', $post->slug) : '/';
                    break;
                case 'rejected':
                    // Rejected posts -> edit page to see rejection reason
                    $redirectUrl = route('posts.edit', $data['post_id']);
                    break;
                case 'new_post_pending':
                    // New post pending approval for admin
                    $post = \App\Models\Post::find($data['post_id']);
                    if ($post) {
                        // Nếu bài viết đã được phê duyệt, chuyển đến trang xem bài viết
                        if ($post->approval_status === 'approved') {
                            $redirectUrl = route('posts.show', $post->slug);
                        } else {
                            // Nếu bài viết chưa được phê duyệt, chuyển đến trang edit để admin xem xét
                            $redirectUrl = route('posts.edit', $post->id);
                        }
                    } else {
                        $redirectUrl = route('admin.posts.pending');
                    }
                    break;
                case 'reply':
                    // Replies -> view post with comment anchor
                    $post = \App\Models\Post::find($data['post_id']);
                    $redirectUrl = $post ? route('posts.show', $post->slug) . '#comment-' . $data['comment_id'] : '/';
                    break;
                default:
                    // Comments -> view post with comment anchor
                    if (isset($data['post_id'])) {
                        $post = \App\Models\Post::find($data['post_id']);
                        $redirectUrl = $post ? route('posts.show', $post->slug) . '#comment-' . ($data['comment_id'] ?? '') : '/';
                    }
            }
        }

        return response()->json(['success' => true, 'redirect_url' => $redirectUrl]);
    }

    public function markAsReadOnly(DatabaseNotification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();
        return response()->json(['count' => $count]);
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
