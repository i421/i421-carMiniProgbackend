<?php

namespace App\Events\Customer;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StoreEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userInfo;
    public $recommender;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $userInfo, string $recommender = '')
    {
        $this->userInfo = $userInfo;
        $this->recommender = $recommender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
