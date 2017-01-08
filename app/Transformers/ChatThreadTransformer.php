<?php

namespace App\Transformers;


use App\ChatParticipant;
use App\ChatThread;

class ChatThreadTransformer
{
    public function transform(ChatThread $thread)
    {
        return [
            'topic'         =>  $thread->topic,
            'messages'      =>  $thread->messages,
            'participants'  =>  $this->transformParticipants($thread)
        ];
    }

    protected function transformParticipants(ChatThread $thread)
    {
        return $thread->participants->transform(function (ChatParticipant $participant) {
            return $this->transformParticipant($participant);
        })->toArray();
    }

    protected function transformParticipant(ChatParticipant $participant)
    {
        return (new ChatParticipantTransformer)->transform($participant);
    }
}