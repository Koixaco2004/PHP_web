<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

/**
 * Thông báo cập nhật bài viết
 * 
 * Gửi thông báo đến tác giả khi admin cập nhật bài viết đã được phê duyệt của họ
 */
class PostUpdatedNotification extends Notification
{
    use Queueable;

    public $post;

    /**
     * Khởi tạo instance thông báo cập nhật bài viết
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Xác định các kênh gửi thông báo
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Tạo nội dung email thông báo cập nhật bài viết
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bài viết của bạn vừa được cập nhật!')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Chúng tôi thông báo rằng bài viết của bạn vừa được cập nhật bởi quản trị viên.')
            ->line('**Tiêu đề bài viết:** ' . $this->post->title)
            ->line('**Chuyên mục:** ' . $this->post->category->name)
            ->action('Xem bài viết', url('/posts/' . $this->post->slug))
            ->line('Bài viết của bạn vẫn được hiển thị công khai với những thay đổi mới nhất.')
            ->salutation('Trân trọng, ' . config('app.name'));
    }

    /**
     * Tạo dữ liệu thông báo lưu trong cơ sở dữ liệu
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Bài viết của bạn vừa được cập nhật.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'type' => 'updated',
        ];
    }

    /**
     * Tạo dữ liệu thông báo ở định dạng mảng
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Bài viết của bạn vừa được cập nhật.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'type' => 'updated',
        ];
    }
}
