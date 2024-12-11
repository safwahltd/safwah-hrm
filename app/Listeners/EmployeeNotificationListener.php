<?php

namespace App\Listeners;

use App\Events\EmployeeNotificationEvent;
use App\Models\User;
use App\Notifications\EmployeeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class EmployeeNotificationListener
{
    public function __construct()
    {

    }
    public function handle(EmployeeNotificationEvent $event): void
    {
        // Find the employee to notify
        $employee = User::find($event->employeeId);

        if ($employee) {
            // Send notification
            Notification::send($employee, new EmployeeNotification(
                $event->type,
                $event->message,
                $event->data
            ));
        }
    }
}
