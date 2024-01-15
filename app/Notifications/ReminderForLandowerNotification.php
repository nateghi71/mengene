<?php

namespace App\Notifications;

use App\chanels\SmsForReminder;
use App\Models\Landowner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderForLandowerNotification extends Notification
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
        $notifiable->notifications()->orderBy('create_at' , 'desc')->skip(6)->destroy();
        return [
            'message' => 'شما بااقای '.$this->landowner->name.' قرار ملاقات دارید.'
        ];
    }

    public function smsReminder(object $notifiable)
    {
        $message = $this->landowner->type_sale . 'با قیمت ' . $this->landowner->getRawOriginal('type_sale') === 'buy' ? $this->landowner->selling_price : $this->landowner->rahn_amount/$this->landowner->rent_amount ;
        return ['name_cus' => $this->landowner->name,'number_cus' => $this->landowner->number,'date' => $this->date , 'message' => $message];
    }
}
