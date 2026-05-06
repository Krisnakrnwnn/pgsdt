<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Email Anda - PGSDT Dalem Tarukan')
            ->greeting('Om Swastyastu, ' . $notifiable->name . '!')
            ->line('Terima kasih telah mendaftar sebagai krama Para Gotra Santana Dalem Tarukan.')
            ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda dan mengaktifkan akun.')
            ->action('Verifikasi Email Sekarang', $verificationUrl)
            ->line('Tautan verifikasi ini akan kedaluwarsa dalam **60 menit**.')
            ->line('Jika Anda tidak merasa mendaftar, abaikan email ini.')
            ->salutation('Om Santih, Santih, Santih Om — Tim PGSDT Dalem Tarukan');
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
