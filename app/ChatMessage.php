<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_thread_id',
        'chat_participant_id',
        'title',
        'body'
    ];

    public function thread()
    {
        $this->belongsTo(ChatThread::class);
    }

    public function participant()
    {
        return $this->belongsTo(ChatParticipant::class);
    }
}
