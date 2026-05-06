<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $member;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $member)
    {
        $this->member = $member;
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
                    ->subject('Member Baru Terdaftar - ' . $this->member->name)
                    ->greeting('Om Swastyastu,')
                    ->line('Member baru telah mendaftar di sistem PGSDT.')
                    ->line('**Nama:** ' . $this->member->name)
                    ->line('**NIK:** ' . $this->member->nik)
                    ->line('**Email:** ' . $this->member->email)
                    ->line('**Kabupaten:** ' . $this->member->kabupaten)
                    ->line('**No. Registrasi:** ' . $this->member->register_number)
                    ->action('Lihat Detail Member', url('/admin/members/' . $this->member->id))
                    ->line('Silakan verifikasi member ini melalui dashboard admin.')
                    ->salutation('Om Santih, Santih, Santih Om');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'member_id' => $this->member->id,
            'member_name' => $this->member->name,
            'register_number' => $this->member->register_number,
        ];
    }
}
