<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\WhitelistedDevice;

class DeviceRegistrationRequested extends Notification
{
    use Queueable;

    protected $device;

    public function __construct(WhitelistedDevice $device)
    {
        $this->device = $device;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database']; // atau tambah 'mail' jika ingin email
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => 'Device Baru Meminta Registrasi',
            'message' => "Device {$this->device->device_name} dari IP {$this->device->ip_address} meminta akses ke {$this->device->clinic->name}",
            'device_id' => $this->device->id,
            'device_name' => $this->device->device_name,
            'clinic_name' => $this->device->clinic->name,
            'ip_address' => $this->device->ip_address,
            'action_url' => route('admin.devices.index', ['status' => 'pending'])
        ];
    }

    /**
     * Get the mail representation of the notification (optional).
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Device Baru Meminta Registrasi')
            ->line("Device baru meminta akses:")
            ->line("Device: {$this->device->device_name}")
            ->line("IP: {$this->device->ip_address}")
            ->line("Klinik: {$this->device->clinic->name}")
            ->action('Review Sekarang', route('admin.devices.index', ['status' => 'pending']))
            ->line('Silakan review dan approve/reject permintaan ini.');
    }
}
