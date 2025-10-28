<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

/**
 * Thông báo phê duyệt bài viết
 * 
 * /**
 * Gửi thông báo đến tác giả khi bài viết của họ được phê duyệt,
 * thông qua email và cơ sở dữ liệu.
 */
class PostApprovedNotification extends Notification
{
    use Queueable;

    public $post;

    /**
     * Khởi tạo instance thông báo phê duyệt bài viết
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
     * Tạo nội dung email thông báo phê duyệt bài viết
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bài viết của bạn đã được phê duyệt!')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Chúng tôi rất vui thông báo rằng bài viết của bạn đã được phê duyệt và hiện đã được hiển thị công khai.')
            ->line('**Tiêu đề bài viết:** ' . $this->post->title)
            ->line('**Chuyên mục:** ' . $this->post->category->name)
            ->action('Xem bài viết', url('/posts/' . $this->post->slug))
            ->line('Cảm ơn bạn đã đóng góp nội dung chất lượng cho cộng đồng của chúng tôi!')
            ->salutation('Trân trọng, ' . config('app.name'));
    }
    /**
     * Tạo dữ liệu thông báo lưu trong cơ sở dữ liệu
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Bài viết của bạn đã được phê duyệt.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'type' => 'approved',
        ];
    }

    /**
     * Tạo dữ liệu thông báo ở định dạng mảng
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Bài viết của bạn đã được phê duyệt.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'type' => 'approved',
        ];
    }
}
