<?php

namespace App\Http\Controllers\Chat;

use App\ChatRoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreChatRoomRequest;
use App\Http\Requests\Chat\UpdateChatRoomRequest;
use App\Repositories\ChatroomRepository;
use App\Repositories\ChatroomRepositoryContract;
use App\Transformers\ChatRoomTransformer;
use Illuminate\Http\Request;

/**
 * @resource ChatRooms
 */
class ChatRoomController extends Controller
{
    /**
     * ChatRooms Repository
     * @var ChatroomRepository
     */
    protected $rooms;

    /**
     * RoomsController Constructor
     * 
     * @param ChatroomRepositoryContract $repository 
     */
    public function __construct(ChatroomRepositoryContract $repository)
    {
        $this->middleware('auth:api')
             ->only(['store', 'update', 'destroy']);

        $this->rooms = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->rooms->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChatRoomRequest $request)
    {
        if ($request->forTeam) {
            return $this->rooms
                        ->forCurrentTeam()
                        ->create($request->all());
        }

        return $this->rooms->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatRoom  $ChatRoom
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return (new ChatRoomTransformer)->transform(
            $this->rooms->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatRoom  $ChatRoom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChatRoomRequest $request,
                           ChatRoom $ChatRoom
    ) {
        $this->rooms->update($ChatRoom, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatRoom  $ChatRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatRoom $ChatRoom)
    {
        return $this->rooms->destroy($ChatRoom);
    }
}
