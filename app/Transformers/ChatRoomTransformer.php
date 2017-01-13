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
            'participants'  =>  $this->transformParticipants($room)
        ];
    }

    protected function transformParticipants(ChatRoom $room)
    {
        return $room->participants->transform(function (ChatParticipant $participant) {
            return $this->transformParticipant($participant);
        })->toArray();
    }

    protected function transformParticipant(ChatParticipant $participant)
    {
        return (new ChatParticipantTransformer)->transform($participant);
    }
}