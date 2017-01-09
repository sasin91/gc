<?php

namespace App\Http\Controllers\Chat;

use App\ChatRoom;
use App\Transformers\ChatRoomTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publicRooms = ChatRoom::onlyPublic()->get();

        if (request()->user()->hasTeams()) {
            return $publicRooms->merge(ChatRoom::forTeam(request()->user()->currentTeam())->get());
        }

        return $publicRooms;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatRoom  $ChatRoom
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return (new ChatRoomTransformer)->transform(ChatRoom::find($id)->load(['team', 'participants']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChatRoom  $ChatRoom
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatRoom $ChatRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatRoom  $ChatRoom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatRoom $ChatRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatRoom  $ChatRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatRoom $ChatRoom)
    {
        //
    }
}
