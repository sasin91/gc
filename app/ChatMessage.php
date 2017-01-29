<?php

namespace App;

use App\Events\Chat\{ChatMessageCreated, ChatMessageUpdated, ChatMessageDeleted};
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'title',
        'body'
    ];

    /**
    * The event map for the model.
    *
    * Allows for object-based events for native Eloquent events.
    *
    * @var array
    */
    protected $events = [
        'created'   =>  ChatMessageCreated::class,
        'updated'   =>  ChatMessageUpdated::class,
        'deleting'  =>  ChatMessageDeleted::class
    ];
    

    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
