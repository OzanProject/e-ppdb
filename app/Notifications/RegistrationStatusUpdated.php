<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationStatusUpdated extends Notification
{
    use Queueable;

    public $status;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $message = null)
    {
        $this->status = $status;
        $this->message = $message;
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
        $mailMessage = (new MailMessage);

        switch ($this->status) {
            case 'verified':
                $mailMessage->subject('Status Pendaftaran: BERKAS DIVERIFIKASI')
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Selamat! Berkas pendaftaran Anda telah selesai diverifikasi oleh panitia.')
                    ->line('Silakan pantau terus website kami untuk pengumuman seleksi selanjutnya.')
                    ->line($this->message ? 'Catatan Panitia: ' . $this->message : '');
                break;

            case 'rejected':
                $mailMessage->subject('Status Pendaftaran: BERKAS DITOLAK')
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Mohon maaf, berkas pendaftaran Anda belum memenuhi syarat atau ditolak.')
                    ->line($this->message ? 'Alasan Penolakan: ' . $this->message : '')
                    ->line('Silakan perbaiki berkas Anda atau hubungi panitia jika ada pertanyaan.');
                break;
            
            case 'accepted':
                $mailMessage->subject('PENGUMUMAN: SELAMAT ANDA DITERIMA!')
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Selamat! Berdasarkan hasil seleksi, Anda dinyatakan DITERIMA sebagai siswa baru.')
                    ->line('Silakan lakukan daftar ulang sesuai jadwal yang ditentukan.')
                    ->action('Cek Pengumuman', url('/'))
                    ->line($this->message ? 'Catatan: ' . $this->message : '');
                break;

            case 'not_accepted':
                 $mailMessage->subject('PENGUMUMAN: Status Seleksi')
                    ->greeting('Halo ' . $notifiable->name . ',')
                    ->line('Terima kasih telah mengikuti proses seleksi.')
                    ->line('Mohon maaf, berdasarkan kuota dan perangkingan, Anda dinyatakan BELUM DITERIMA saat ini.')
                    ->line('Tetap semangat!');
                break;

            default:
                $mailMessage->subject('Update Status Pendaftaran')
                     ->line('Status pendaftaran Anda telah diperbarui menjadi: ' . ucfirst($this->status));
                break;
        }

        return $mailMessage->line('Terima kasih telah mendaftar.');
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
