<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Comment;
use App\Models\Post;

/**
 * Thông báo khi có reply mới cho bình luận của người dùng.
 * Gửi dữ liệu thông báo vào cơ sở dữ liệu để hiển thị trên giao diện.
 */
class NewReplyNotification extends Notification
{
    use Queueable;

    public $comment;
    public $post;

    /**
     * Khởi tạo thông báo với thông tin bình luận và bài viết liên quan.
     */
    public function __construct(Comment $comment, Post $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    /**
     * Xác định kênh gửi thông báo (lưu vào cơ sở dữ liệu).
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Chuẩn bị dữ liệu thông báo để lưu vào bảng notifications.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Có reply mới cho bình luận của bạn.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'parent_comment_id' => $this->comment->parent_id,
            'user_id' => $this->comment->user->id,
            'user_name' => $this->comment->user->name,
            'type' => 'reply',
        ];
    }

    /**
     * Chuẩn bị dữ liệu thông báo cho đầu ra dạng mảng.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Có reply mới cho bình luận của bạn.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'parent_comment_id' => $this->comment->parent_id,
            'user_id' => $this->comment->user->id,
            'user_name' => $this->comment->user->name,
            'type' => 'reply',
        ];
    }
}
