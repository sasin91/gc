<?php

namespace App\Transformers;


use App\ChatMessage;

class ChatMessageTransformer
{
    public function transform(ChatMessage $message)
    {
        return [
            'thread'        =>  $message->thread,
            'participant'   =>  $this->transformParticipant($message),
            'title'         =>  $message->title,
            'body'          =>  $message->body
        ];
    }

    protected function transformParticipant(ChatMessage $message)
    {
        return (new ChatParticipantTransformer)->transform($message->participant);
    }
}