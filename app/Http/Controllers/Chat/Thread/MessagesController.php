<?php

namespace App\Http\Controllers\Chat\Thread;

use App\ChatMessage;
use App\ChatParticipant;
use App\ChatThread;
use App\Transformers\ChatMessageTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ChatThread $thread)
    {
        return $thread->messages;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ChatThread $thread)
    {
        if (! $thread->isPublic ) {
            abort_unless($request->user()->onTeam($thread->team), 403, "User must be a member of the Team owning a private thread.");
        }
        if (ChatParticipant::where('chat_thread_id', $thread->id)
                           ->where('user_id', $request->user()->id)
                           ->get()
                           ->isEmpty()
        ) {
            $thread->participateAs($request->user());
        }

        $thread->messages()->save(new ChatMessage($request->all()));
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChatMessage  $chatMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatMessage $chatMessage)
    {
        //
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
