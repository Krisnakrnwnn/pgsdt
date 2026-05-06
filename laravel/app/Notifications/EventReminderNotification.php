<?php

namespace App\Notifications;

use App\Models\Agenda;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $agenda;

    /**
     * Create a new notification instance.
     */
    public function __construct(Agenda $agenda)
    {
        $this->agenda = $agenda;
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
        $eventDate = $this->agenda->event_date->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $eventTime = $this->agenda->event_date->format('H:i');
        
        return (new MailMessage)
                    ->subject('Pengingat: Event Besok - ' . $this->agenda->title)
                    ->greeting('Om Swastyastu, ' . $notifiable->name)
                    ->line('Ini adalah pengingat bahwa Anda terdaftar untuk mengikuti event berikut:')
                    ->line('**' . $this->agenda->title . '**')
                    ->line('📅 **Tanggal:** ' . $eventDate)
                    ->line('🕐 **Waktu:** ' . $eventTime . ' WITA')
                    ->line('📍 **Lokasi:** ' . $this->agenda->location)
                    ->line('Event akan dimulai **besok**. Pastikan Anda sudah mempersiapkan segala sesuatunya.')
                    ->action('Lihat Detail Event', url('/events/' . $this->agenda->slug))
                    ->line('Jika ada perubahan atau Anda tidak dapat hadir, mohon informasikan kepada kami.')
                    ->line('Kami menunggu kehadiran Anda!')
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
            'agenda_id' => $this->agenda->id,
            'agenda_title' => $this->agenda->title,
            'event_date' => $this->agenda->event_date,
        ];
    }
}
