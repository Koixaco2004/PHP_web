<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsletterWelcome extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Chào mừng bạn đến với bản tin của chúng tôi!')
                    ->greeting('Xin chào ' . $notifiable->name . '!')
                    ->line('Cảm ơn bạn đã đăng ký nhận bản tin từ News Portal.')
                    ->line('Bạn sẽ nhận được những tin tức mới nhất và hấp dẫn nhất từ chúng tôi.')
                    ->action('Khám phá ngay', url('/'))
                    ->line('Nếu bạn muốn hủy đăng ký, vui lòng liên hệ với chúng tôi.')
                    ->salutation('Trân trọng,')
                    ->salutation('Đội ngũ News Portal');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}