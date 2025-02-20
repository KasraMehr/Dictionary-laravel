<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WordAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $teamId;
    public $wordId;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
      $this->teamId = $teamId;
      $this->wordId = $wordId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('word.' . $this->wordId),
        ];
    }
}
