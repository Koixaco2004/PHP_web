<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

/**
 * Thông báo gửi đến người dùng khi bài viết của họ bị từ chối
 * Gửi qua email và lưu vào cơ sở dữ liệu để hiển thị trên giao diện
 */
class PostRejectedNotification extends Notification
{
    use Queueable;

    public $post;

    /**
     * Khởi tạo instance thông báo với bài viết bị từ chối
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Xác định các kênh gửi thông báo (email và database)
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Tạo nội dung email thông báo bài viết bị từ chối
     * Bao gồm tiêu đề, lý do từ chối và đường link chỉnh sửa
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
     * Tạo dữ liệu lưu vào cơ sở dữ liệu notifications
     * Bao gồm thông tin bài viết và lý do từ chối để người dùng xem sau
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
     * Tạo mảng thông tin thông báo cho API hoặc broadcast
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
