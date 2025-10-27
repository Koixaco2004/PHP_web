<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Đánh dấu thông báo là đã đọc và chuyển hướng phù hợp.
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        // Đảm bảo thông báo thuộc về người dùng đã xác thực
        if ($notification->notifiable_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        // Xác định URL chuyển hướng dựa trên loại thông báo
        $data = $notification->data;
        $redirectUrl = '/';

        if (isset($data['type'])) {
            switch ($data['type']) {
                case 'approved':
                    // Bài viết đã phê duyệt -> xem bài viết
                    $post = \App\Models\Post::find($data['post_id']);
                    $redirectUrl = $post ? route('posts.show', $post->slug) : '/';
                    break;
                case 'rejected':
                    // Bài viết bị từ chối -> trang chỉnh sửa để xem lý do từ chối
                    $redirectUrl = route('posts.edit', $data['post_id']);
                    break;
                case 'new_post_pending':
                    // Bài viết mới đang chờ phê duyệt cho admin
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
                    // Phản hồi -> xem bài viết với anchor bình luận
                    $post = \App\Models\Post::find($data['post_id']);
                    $redirectUrl = $post ? route('posts.show', $post->slug) . '#comment-' . $data['comment_id'] : '/';
                    break;
                default:
                    // Bình luận -> xem bài viết với anchor bình luận
                    if (isset($data['post_id'])) {
                        $post = \App\Models\Post::find($data['post_id']);
                        $redirectUrl = $post ? route('posts.show', $post->slug) . '#comment-' . ($data['comment_id'] ?? '') : '/';
                    }
            }
        }

        return response()->json(['success' => true, 'redirect_url' => $redirectUrl]);
    }

    /**
     * Đánh dấu thông báo là đã đọc mà không chuyển hướng.
     */
    public function markAsReadOnly(DatabaseNotification $notification)
    {
        // Đảm bảo thông báo thuộc về người dùng đã xác thực
        if ($notification->notifiable_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Lấy số lượng thông báo chưa đọc.
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotifications->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Đánh dấu tất cả thông báo là đã đọc.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}
