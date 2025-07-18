<?php

namespace App\Events;

use App\Models\JobOpening;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckJobForExpiry
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $job;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\JobOpening  $job
     * @return void
     */
    public function __construct(JobOpening $job)
    {
        $this->job = $job;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
