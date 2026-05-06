<?php

namespace App\Notifications;

use App\Models\Agenda;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $agenda;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Agenda $agenda, $status)
    {
        $this->agenda = $agenda;
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
        $eventDate = $this->agenda->event_date->locale('id')->isoFormat('dddd, D MMMM YYYY');
        $eventTime = $this->agenda->event_date->format('H:i');
        
        $message = (new MailMessage)
                    ->greeting('Om Swastyastu, ' . $notifiable->name);

        if ($this->status === 'confirmed') {
            return $message->subject('Pendaftaran Event Dikonfirmasi - ' . $this->agenda->title)
                    ->line('Selamat! Pendaftaran Anda untuk event berikut telah **dikonfirmasi**:')
                    ->line('**' . $this->agenda->title . '**')
                    ->line('📅 **Tanggal:** ' . $eventDate)
                    ->line('🕐 **Waktu:** ' . $eventTime . ' WITA')
                    ->line('📍 **Lokasi:** ' . $this->agenda->location)
                    ->line('Anda akan menerima email pengingat H-1 sebelum event dimulai.')
                    ->action('Lihat Detail Event', url('/events/' . $this->agenda->slug))
                    ->line('Harap hadir tepat waktu. Kami menantikan kehadiran Anda!')
                    ->salutation('Om Santih, Santih, Santih Om');
            
        } elseif ($this->status === 'cancelled') {
            return $message->subject('Pendaftaran Event Dibatalkan - ' . $this->agenda->title)
                    ->line('Pendaftaran Anda untuk event berikut telah dibatalkan:')
                    ->line('**Event:** ' . $this->agenda->title)
                    ->line('Jika ini bukan permintaan Anda, silakan hubungi kami.')
                    ->line('Terima kasih atas pengertiannya.')
                    ->salutation('Om Santih, Santih, Santih Om');
        } else {
            // pending status (jika masih digunakan)
            return $message->subject('Pendaftaran Event Diterima - ' . $this->agenda->title)
                    ->line('Terima kasih telah mendaftar untuk event:')
                    ->line('**' . $this->agenda->title . '**')
                    ->line('📅 **Tanggal:** ' . $eventDate)
                    ->line('🕐 **Waktu:** ' . $eventTime . ' WITA')
                    ->line('📍 **Lokasi:** ' . $this->agenda->location)
                    ->line('Pendaftaran Anda sedang dalam proses peninjauan.')
                    ->line('Kami akan mengirimkan konfirmasi segera.')
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
            'agenda_id' => $this->agenda->id,
            'agenda_title' => $this->agenda->title,
            'status' => $this->status,
        ];
    }
}
