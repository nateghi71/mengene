<?php

namespace App\Notifications;

use App\chanels\SmsForReminder;
use App\Models\SpecialFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderForSpecialFileNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public SpecialFile $file;
    public $date;
    public function __construct(SpecialFile $file , $date)
    {
        $this->file = $file;
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
            'message' => 'شما با مالک '.$this->file->name.' قرار ملاقات دارید.'
        ];
    }

    public function smsReminder(object $notifiable)
    {
        $message = $this->file->type_sale . ' خانه اش را دارد.' ;
        return ['name_cus' => $this->file->name,'number_cus' => $this->file->number,'date' => $this->date , 'message' => $message];
    }

}
