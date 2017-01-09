<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_room_id',
        'chat_participant_id',
        'title',
        'body'
    ];

    public function thread()
    {
        $this->belongsTo(ChatRoom::class);
    }

    public function participant()
    {
        return $this->belongsTo(ChatParticipant::class);
    }
}
