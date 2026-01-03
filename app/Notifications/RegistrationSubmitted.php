<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationSubmitted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $registration;

    /**
     * Create a new notification instance.
     */
    public function __construct($registration)
    {
        $this->registration = $registration;
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
            ->subject('Pendaftaran Berhasil Dikirim - E-PPDB')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Terima kasih telah melakukan pendaftaran PPDB.')
            ->line('Kode Pendaftaran Anda: ' . $this->registration->registration_code)
            ->line('Saat ini data Anda sedang dalam proses verifikasi oleh panitia.')
            ->line('Silakan pantau status pendaftaran Anda melalui dashboard secara berkala.')
            ->action('Cek Dashboard', route('student.dashboard'));
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
