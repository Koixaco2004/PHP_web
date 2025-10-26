<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

class PostApprovedNotification extends Notification
{
    use Queueable;

    public $post;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bài viết của bạn đã được phê duyệt!')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Chúng tôi rất vui thông báo rằng bài viết của bạn đã được phê duyệt và hiện đã được xuất bản.')
            ->line('**Tiêu đề bài viết:** ' . $this->post->title)
            ->line('**Chuyên mục:** ' . $this->post->category->name)
            ->action('Xem bài viết', url('/posts/' . $this->post->slug))
            ->line('Cảm ơn bạn đã đóng góp nội dung chất lượng cho cộng đồng của chúng tôi!')
            ->salutation('Trân trọng, ' . config('app.name'));
    }

    /**
     * Get the database representation of the notification.
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
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
