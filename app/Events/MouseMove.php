<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MouseMove
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $position;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
      $this->userId = $userId;
      $this->position = $position;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('team.' . $this->userId),
        ];
    }
}
