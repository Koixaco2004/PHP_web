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
    public $hasChanges;

    /**
     * Khởi tạo instance thông báo phê duyệt bài viết
     */
    public function __construct(Post $post, $hasChanges = false)
    {
        $this->post = $post;
        $this->hasChanges = $hasChanges;
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
        $subject = $this->hasChanges ? 'Bài viết của bạn đã được cập nhật và phê duyệt!' : 'Bài viết của bạn đã được phê duyệt!';
        $line = $this->hasChanges
            ? 'Chúng tôi rất vui thông báo rằng bài viết của bạn đã được cập nhật, phê duyệt và hiện đã được hiển thị công khai.'
            : 'Chúng tôi rất vui thông báo rằng bài viết của bạn đã được phê duyệt và hiện đã được hiển thị công khai.';

        return (new MailMessage)
            ->subject($subject)
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line($line)
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
        $message = $this->hasChanges
            ? 'Bài viết của bạn đã được cập nhật và phê duyệt.'
            : 'Bài viết của bạn đã được phê duyệt.';

        return [
            'message' => $message,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'type' => 'approved',
            'has_changes' => $this->hasChanges,
        ];
    }

    /**
     * Tạo dữ liệu thông báo ở định dạng mảng
     */
    public function toArray(object $notifiable): array
    {
        $message = $this->hasChanges
            ? 'Bài viết của bạn đã được cập nhật và phê duyệt.'
            : 'Bài viết của bạn đã được phê duyệt.';

        return [
            'message' => $message,
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'type' => 'approved',
            'has_changes' => $this->hasChanges,
        ];
    }
}
