<?php

namespace App\Http\Controllers\Chat\Room;

use App\ChatParticipant;
use app\Transformers\ChatParticipantTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @resource ChatParticipants
 */
class ParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatParticipant  $chatParticipant
     * @return \Illuminate\Http\Response
     */
    public function show(ChatParticipant $chatParticipant)
    {
        return (new ChatParticipantTransformer)->transform($chatParticipant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatParticipant  $chatParticipant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatParticipant $chatParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatParticipant  $chatParticipant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatParticipant $chatParticipant)
    {
        //
    }
}
