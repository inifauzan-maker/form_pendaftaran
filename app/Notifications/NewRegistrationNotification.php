<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegistrationNotification extends Notification
{
    use Queueable;

    public function __construct(private Registration $registration)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pendaftaran Baru: ' . $this->registration->unique_code)
            ->greeting('Halo ' . $notifiable->name)
            ->line('Ada pendaftar baru Art Camp.')
            ->line('Nama: ' . $this->registration->full_name)
            ->line('Sekolah: ' . $this->registration->school)
            ->line('Lokasi Belajar: ' . $this->registration->study_location)
            ->line('Program: ' . $this->registration->program)
            ->action('Lihat Dashboard', route('dashboard'))
            ->line('Kode unik: ' . $this->registration->unique_code);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'registration_id' => $this->registration->id,
            'unique_code' => $this->registration->unique_code,
            'full_name' => $this->registration->full_name,
            'study_location' => $this->registration->study_location,
        ];
    }
}
