<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EditText
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;

    public $documentId;

    public $sectionId;

    public $text;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        $this->userId = $userId;
        $this->documentId = $documentId;
        $this->sectionId = $sectionId;
        $this->text = $text;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('document.'.$this->documentId),
        ];
    }
}
