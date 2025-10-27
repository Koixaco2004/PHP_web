<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Thông báo đặt lại mật khẩu tùy chỉnh
 * 
 * Lớp này xử lý việc gửi email thông báo đặt lại mật khẩu cho người dùng
 * với nội dung bằng tiếng Việt.
 */
class ResetPasswordNotification extends ResetPassword
{
    /**
     * Tạo nội dung email thông báo đặt lại mật khẩu
     *
     * @param  mixed  $notifiable Người dùng nhận thông báo
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Tạo URL chứa token và email để xác thực yêu cầu đặt lại mật khẩu
        $url = url(config('app.url') . route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false));

        return (new MailMessage)
            ->subject('Đặt lại mật khẩu')
            ->greeting('Xin chào!')
            ->line('Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.')
            ->action('Đặt lại mật khẩu', $url)
            ->line('Link đặt lại mật khẩu này sẽ hết hạn sau ' . config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') . ' phút.')
            ->line('Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.')
            ->salutation('Trân trọng, ' . config('app.name'));
    }
}
