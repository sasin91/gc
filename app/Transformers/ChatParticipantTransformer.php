<?php

namespace app\Transformers;


use App\ChatParticipant;

class ChatParticipantTransformer
{
    public function transform(ChatParticipant $participating)
    {
        return [
            'name'      =>  $participating->user->name,
            'Rooms'  	=>  $participating->Rooms
        ];
    }
}