<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

class PostRejectedNotification extends Notification
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
            ->subject('Bài viết của bạn đã bị từ chối')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Rất tiếc, bài viết của bạn đã không được phê duyệt.')
            ->line('**Tiêu đề bài viết:** ' . $this->post->title)
            ->line('**Lý do từ chối:** ' . $this->post->rejection_reason)
            ->line('Vui lòng chỉnh sửa bài viết theo yêu cầu và gửi lại để được xem xét.')
            ->action('Chỉnh sửa bài viết', url('/posts/' . $this->post->id . '/edit'))
            ->line('Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.')
            ->salutation('Trân trọng, ' . config('app.name'));
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Bài viết của bạn đã bị từ chối.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'rejection_reason' => $this->post->rejection_reason,
            'type' => 'rejected',
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
            'message' => 'Bài viết của bạn đã bị từ chối.',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'type' => 'rejected',
        ];
    }
}
