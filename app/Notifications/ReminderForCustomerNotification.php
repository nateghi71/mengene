<?php

namespace App\Notifications;

use App\chanels\SmsForReminder;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderForCustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Customer $customer;
    public $date;

    public function __construct(Customer $customer , $date)
    {
        $this->customer = $customer;
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
//        $notifiable->notifications()->orderBy('create_at' , 'desc')->skip(6)->destroy();
        return [
            'message' => 'شما با متقاضی '.$this->customer->name.' قرار ملاقات دارید.'
        ];
    }

    public function smsReminder(object $notifiable)
    {
        $message = $this->customer->type_sale . ' خانه ای را دارد.' ;
        return ['name_cus' => $this->customer->name,'number_cus' => $this->customer->number,'date' => $this->date , 'message' => $message];
    }
}
