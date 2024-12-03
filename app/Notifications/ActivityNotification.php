<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityNotification extends Notification
{
    use Queueable;

    public $activityData;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($activityData)
    {
        $this->activityData = $activityData;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /*public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'activity_type' => $activityData,
            'message' => $this->message,
        ]);
    }*/
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Notification')
            ->line($this->activityData['message'])
            ->action('View Details', $this->activityData['url']);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->activityData['type'],
            'message' => $this->activityData['message'],
            'url' => $this->activityData['url'],
        ];
    }
}
