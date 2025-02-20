<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $teamId;
    public $categoryId;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
      $this->teamId = $teamId;
      $this->categoryId = $categoryId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('category.' . $this->categoryId),
        ];
    }
}
