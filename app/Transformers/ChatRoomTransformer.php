<?php

namespace App\Transformers;


use App\ChatParticipant;
use App\ChatRoom;

class ChatRoomTransformer
{
    public function transform(ChatRoom $room)
    {
        return [
            'topic'         =>  $room->topic,
            'messages'      =>  $room->messages,
            'users'         =>  $room->users
        ];
    }
}