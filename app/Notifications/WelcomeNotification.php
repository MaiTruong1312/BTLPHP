<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Chào mừng bạn đến với ' . config('app.name'))
                    ->greeting('Xin chào ' . $notifiable->name . '!')
                    ->line('Chúc mừng bạn đã xác thực tài khoản thành công.')
                    ->line('Tài khoản của bạn đã sẵn sàng. Hãy đăng nhập để bắt đầu khám phá các cơ hội nghề nghiệp.')
                    ->action('Đăng nhập ngay', route('login'))
                    ->line('Cảm ơn bạn đã tham gia cùng chúng tôi!');
    }
}