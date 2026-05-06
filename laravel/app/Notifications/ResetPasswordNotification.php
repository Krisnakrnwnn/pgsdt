<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Atur Ulang Kata Sandi - Dalem Tarukan')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di Portal PGSDT Dalem Tarukan.')
            ->action('Atur Ulang Kata Sandi', $resetUrl)
            ->line('Tautan ini akan kedaluwarsa dalam **60 menit**.')
            ->line('Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini. Akun Anda tetap aman.')
            ->salutation('Salam, Tim PGSDT Dalem Tarukan');
    }
}
