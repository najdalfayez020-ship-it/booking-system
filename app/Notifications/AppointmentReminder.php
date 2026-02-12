<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage; // للتخزين في DB
use App\Models\Appointment;

class AppointmentReminder extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        // نستخدم قاعدة البيانات لعرض الإشعار داخل التطبيق
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Reminder: You have an appointment for {$this->appointment->service->name} on {$this->appointment->appointment_date} at {$this->appointment->appointment_time}.",
            'appointment_id' => $this->appointment->id,
        ];
    }
}
