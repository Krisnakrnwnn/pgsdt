<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberVerifiedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($status)
    {
        $this->status = $status;
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
        $message = (new MailMessage)
                    ->greeting('Om Swastyastu, ' . $notifiable->name);

        if ($this->status === 'approved') {
            return $message->subject('Selamat Datang di PGSDT - Akun Anda Aktif!')
                    ->line('Selamat! Email Anda telah berhasil diverifikasi dan akun Anda sekarang aktif.')
                    ->line('**Nomor Registrasi:** ' . $notifiable->register_number)
                    ->line('Anda sekarang dapat mengakses semua fitur member, termasuk:')
                    ->line('• Mendaftar ke event dan kegiatan')
                    ->line('• Mengakses informasi eksklusif member')
                    ->line('• Mengelola profil Anda')
                    ->line('• Terhubung dengan sesama anggota')
                    ->action('Lihat Profil Anda', url('/profile'))
                    ->line('Terima kasih telah bergabung dengan Para Gotra Santana Dalem Tarukan!')
                    ->salutation('Om Santih, Santih, Santih Om');
            
        } else {
            return $message->subject('Status Keanggotaan Anda')
                    ->line('Terima kasih atas minat Anda untuk bergabung dengan Para Gotra Santana Dalem Tarukan.')
                    ->line('Saat ini, keanggotaan Anda masih dalam proses peninjauan.')
                    ->line('Kami akan menghubungi Anda segera setelah proses verifikasi selesai.')
                    ->line('Jika ada pertanyaan, silakan hubungi kami.')
                    ->salutation('Om Santih, Santih, Santih Om');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
