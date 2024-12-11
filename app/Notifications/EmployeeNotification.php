<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeNotification extends Notification
{
    use Queueable;

    public $type;
    public $message;
    public $data;

    public function __construct($type, $message,$data = [])
    {
        $this->type = $type;
        $this->message = $message;
        $this->data = $data;
    }
    public function via(object $notifiable): array
    {
        return ['database'];
    }
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
