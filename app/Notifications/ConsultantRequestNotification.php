<?php

namespace App\Notifications;

use App\chanels\SmsToConsultant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConsultantRequestNotification extends Notification
{
    use Queueable;

    public User $consultant;
    public function __construct(User $consultant)
    {
        $this->consultant = $consultant;
    }


    public function via(object $notifiable): array
    {
        return ['database' , SmsToConsultant::class];
    }


    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->consultant->name .' درخواست همکاری به عنوان مشاور را دارد.'
        ];
    }
    public function toSms(object $notifiable)
    {
        return $this->consultant->name;
    }
}
