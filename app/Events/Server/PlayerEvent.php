<?php

namespace App\Events\Server;

use App\Server;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

abstract class PlayerEvent
{
    use InteractsWithSockets, SerializesModels;

    public $server;

    public $player;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Server $server, User $player)
    {
        $this->server = $server;
        $this->player = $player;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('server-'.$this->server->id);
    }
}
