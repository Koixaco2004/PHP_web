<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use App\Models\Comment;

/**
 * Thông báo khi có bình luận mới cho bài viết của người dùng.
 * Lưu thông báo vào cơ sở dữ liệu để người dùng xem lịch sử.
 */
class NewCommentNotification extends Notification
{
    use Queueable;

    public $post;
    public $comment;

    /**
     * Khởi tạo thông báo với bài viết và bình luận.
     */
    public function __construct(Post $post, Comment $comment)
    {
        $this->post = $post;
        $this->comment = $comment;
    }

    /**
     * Xác định kênh gửi thông báo.
     * Sử dụng kênh database để lưu trữ thông báo.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Chuẩn bị dữ liệu thông báo để lưu vào cơ sở dữ liệu.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Có bình luận mới cho bài viết của bạn.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'user_id' => $this->comment->user->id,
            'user_name' => $this->comment->user->name,
            'type' => 'comment',
        ];
    }

    /**
     * Chuyển đổi thông báo thành mảng.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Có bình luận mới cho bài viết của bạn.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'comment_id' => $this->comment->id,
            'comment_content' => $this->comment->content,
            'user_id' => $this->comment->user->id,
            'user_name' => $this->comment->user->name,
            'type' => 'comment',
        ];
    }
}
