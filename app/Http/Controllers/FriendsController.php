<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFriendRequest;
use App\Http\Requests\UpdateFriendRequest;
use App\Repositories\FriendsRepositoryContract as FriendsRepository;
use App\User;
use Hootlex\Friendships\Models\Friendship;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

/**
 * @resource Friends
 */
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

    /**
     * Whether the current User is friends with given.
     * 
     * @param  integer $user_id
     * @return boolean
     */
    public function contains($user_id)
    {
        return $this->friends->contains(User::findOrFail($user_id));
    }

    /**
     * Get mutual friends.
     * 
     * @param  integer $user_id
     * @return Collection
     */
    public function mutual($user_id)
    {
        return $this->friends->mutual(User::findOrFail($user_id));
    }

    /**
     * Get denied friendship requests.
     * @return Collection
     */
    public function denied()
    {
        return $this->friends->denied();
    }

    /**
     * Get blocked friends.
     * @return Collection
     */
    public function blocked()
    {
        return $this->friends->blocked();
    }

    /**
     * Whether the given has blocked the current User.
     * @param  integer  $user_id
     * @return boolean
     */
    public function hasBlockedMe($user_id)
    {
        return User::findOrFail($user_id)->hasBlocked(request()->user());
    }

    /**
     * Get pending friends.
     * @return Collection
     */
    public function pending()
    {
        return $this->friends->pending();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return $this->friends->accepted();
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
     * @param  integer $user_id
     * @return Friendship
     */
    public function show($user_id)
    {
        return $this->friends->showFriendship(User::findOrFail($user_id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFriendRequest $request, $user_id)
    {
        $friend = User::findOrFail($user_id);

        if ($request->has('deny')) {
            $this->friends->updateNewFriend(
                $friend, 
                (bool)$request->deny
            );
        }

        if ($request->has('accept')) {
            $this->friends->updateNewFriend(
                $friend, 
                ! (bool)$request->accept
            );
        }        

        if ($request->has('block')) {
            $this->friends->updateExistingFriend(
                $friend,
                (bool)$request->block
            );
        }

        if ($request->has('unblock')) {
            $this->friends->updateExistingFriend(
                $friend,
                ! (bool)$request->unblock
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $user_id
     * @return boolean
     */
    public function destroy($user_id)
    {
        return $this->friends->unfriend(User::findOrFail($user_id));
    }
}
