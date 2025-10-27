<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

/**
 * Thông báo cho quản trị viên khi có bài viết mới chờ phê duyệt.
 * Lưu trữ thông báo trong cơ sở dữ liệu với thông tin chi tiết về bài viết và tác giả.
 */
class NewPostPendingNotification extends Notification
{
    use Queueable;

    public $post;

    /**
     * Khởi tạo thông báo với bài viết cần phê duyệt.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Xác định kênh phân phối thông báo (chỉ lưu vào cơ sở dữ liệu).
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Định dạng dữ liệu thông báo để lưu vào cơ sở dữ liệu.
     * Bao gồm thông tin bài viết và tác giả để hiển thị trong bảng điều khiển.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Có bài viết mới cần phê duyệt.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'author_name' => $this->post->user->name,
            'author_id' => $this->post->user_id,
            'type' => 'new_post_pending',
        ];
    }

    /**
     * Định dạng dữ liệu thông báo cho mảng (không sử dụng trong lớp này).
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
