<?php

namespace App\Listeners;

use App\Events\GeneralNotificationEvent;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class GeneralNotificationListener
{
    public function __construct()
    {
        //
    }

    public function handle(object $event): void
    {
        // Get the users to notify (e.g., admins)
        $admins = User::where('role', 'admin')->get();

        // Send notification
        Notification::send($admins, new AdminNotification(
            $event->type,
            $event->message,
            $event->data
        ));
    }
}
