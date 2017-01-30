<?php

namespace App\Events\Forum;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForumPostDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $forumPost;

    /**
     * Create a new event instance.
     *
     * @param ForumPost $forumPost 
     * @return void
     */
    public function __construct(\App\ForumPost $forumPost)
    {
        $this->forumPost = $forumPost;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('forum.forum-thread-'.$this->forumPost->thread->id);
    }
}