<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AutoSave
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $documentId;
    public $content;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
      $this->userId = $userId;
      $this->documentId = $documentId;
      $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('autosave.' . $this->documentId),
        ];
    }
}
