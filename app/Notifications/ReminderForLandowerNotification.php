<?php

namespace App\Notifications;

use App\chanels\SmsForReminder;
use App\Models\Landowner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderForLandowerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Landowner $landowner;
    public $date;

    public function __construct(Landowner $landowner , $date)
    {
        $this->landowner = $landowner;
        $this->date = $date;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database' , SmsForReminder::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'شما با مالک '.$this->landowner->name.' قرار ملاقات دارید.'
        ];
    }

    public function smsReminder(object $notifiable)
    {
        $message = $this->landowner->type_sale . ' خانه اش را دارد.' ;
        return ['name_cus' => $this->landowner->name,'number_cus' => $this->landowner->number,'date' => $this->date , 'message' => $message];
    }
}
