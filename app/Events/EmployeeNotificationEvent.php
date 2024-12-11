<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmployeeNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $message;
    public $employeeId;
    public $data;

    public function __construct($type, $message, $employeeId, $data = [])
    {
        $this->type = $type;
        $this->message = $message;
        $this->employeeId = $employeeId;
        $this->data = $data;
    }
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
