<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

/**
 * Gửi email xác thực địa chỉ email cho người dùng
 * 
 * Lớp này tạo và định dạng email xác thực với nội dung tiếng Việt,
 * bao gồm liên kết tạm thời để người dùng xác minh tài khoản của họ.
 */
class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Xây dựng nội dung email xác thực
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Xác thực địa chỉ email')
            ->greeting('Xin chào ' . $notifiable->name . '!')
            ->line('Vui lòng nhấn vào nút bên dưới để xác thực địa chỉ email của bạn.')
            ->action('Xác thực địa chỉ Email', $verificationUrl)
            ->line('Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này.')
            ->salutation('Trân trọng, ' . config('app.name'));
    }

    /**
     * Tạo liên kết xác thực có chữ ký tạm thời cho người dùng
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        // Tạo URL có chữ ký tạm thời hết hạn sau số phút được cấu hình
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
