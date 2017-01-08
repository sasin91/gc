<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatParticipant extends Model
{
    protected $fillable = [
        'user_id',
        'chat_thread_id',
    ];

    public function scopeParticipatorsIn()
    {

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(ChatThread::class);
    }
}
