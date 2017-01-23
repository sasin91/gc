<?php

namespace App\Http\Controllers\Chat\Room;

use App\ChatMessage;
use App\ChatParticipant;
use App\ChatRoom;
use App\Transformers\ChatMessageTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @resource ChatMessages
 */
class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ChatRoom $room)
    {
        return $room->messages;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ChatRoom $room)
    {
        if (! $room->isPublic ) {
            abort_unless($request->user()->onTeam($room->team), 403, "User must be a member of the Team owning a private Room.");
        }
        if (ChatParticipant::where('chat_Room_id', $room->id)
                           ->where('user_id', $request->user()->id)
                           ->get()
                           ->isEmpty()
        ) {
            $room->participateAs($request->user());
        }

        $room->messages()->save(new ChatMessage($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return \Illuminate\Http\Response
     */
    public function show(ChatMessage $chatMessage)
    {
        return (new ChatMessageTransformer)->transform($chatMessage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatMessage  $chatMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatMessage $chatMessage)
    {
        //
    }
}
