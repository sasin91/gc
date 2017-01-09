<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFriendRequest;
use App\Http\Requests\UpdateFriendRequest;
use App\Repositories\FriendsRepositoryContract as FriendsRepository;
use App\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    /**
     * @var FriendsRepository
     */
    protected $friends;

    /**
     * FriendsController Constructor
     *
     * @param   FriendsRepository   $friends
     */
    public function __construct(FriendsRepository $friends)
    {
        $this->friends = $friends;
    }

    public function isFriendsWith(User $user)
    {
        return request()->user()->isFriendWith($user);
    }

    public function mutual(User $user)
    {
        return $this->friends->mutual($user);
    }

    public function denied()
    {
        return request()->user()->getDeniedFriendships();
    }

    public function blocked()
    {
        return request()->user()->getBlockedFriendships();
    }

    public function pending()
    {
        return request()->user()->getPendingFriendships();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return request()->user()->getFriends();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFriendRequest $request)
    {
        $this->friends->befriend(User::findOrFail($request->user_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->friends->showFriendship($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFriendRequest $request, User $user)
    {
        if ($request->has(['accept', 'deny'])) {
            return $this->friends->updateNewFriend($request, $user);
        }

        if ($request->has(['block', 'unblock'])) {
            return $this->friends->updateExistingFriend($request, $user);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return $this->friends->unfriend($user);
    }
}
