<?php

namespace App\Repositories;

use App\Http\Requests\UpdateFriendRequest;
use App\Repositories\FriendsRepositoryContract;
use App\User;
use Hootlex\Friendships\Models\Friendship;

/**
 * Class FriendsRepository
 * @package App\Repositories;
 */
class FriendsRepository implements FriendsRepositoryContract
{
	/**
	 * Befriend given User.
	 * 
	 * @param  User   $friend
	 * @return Friendship|boolean
	 */
	public function befriend(User $friend)
	{
		if (request()->user()->canBefriend($friend)) {
			return request()->user()->befriend($friend);
		}
	}

	/**
	 * Remove a Friend from your Friends.
	 * 
	 * @param  User   $friend
	 * @return boolean
	 */
	public function unfriend(User $friend)
	{
		if (request()->user()->isFriendWith($friend)) {
			return request()->user()->unfriend($friend);
		}
	}

	/**
	 * Get the mutual friends between current and given User.
	 * 
	 * @param  User   $friend
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function mutual(User $friend)
	{
		if (request()->user()->isFriendWith($user)) {
			return request()->user()->getMutualFriends($user);
		}
	}

	/**
	 * Display the Friendship between the current and given User.
	 * 
	 * @param  User   $friend
	 * @return Friendship
	 */
	public function showFriendship(User $friend)
	{
		if (request()->user()->isFriendWith($friend)) {
            return request()->user()->getFriendship($friend);
        }
	}

	/**
	 * Handle a new Friend.
	 * 
	 * @param  UpdateFriendRequest $request
	 * @param  User                $friend   
	 * @return boolean              
	 */
    public function updateNewFriend(UpdateFriendRequest $request, User $friend)
    {
        if ($request->accept) {
        	return $request->user()->acceptFriendRequest($friend);
        }

        if ($request->deny) {
        	return $request->user()->denyFriendRequest($friend);
        }

        return false;
    }

    /**
     * Handle updating an existing Friend.
     * 
     * @param  UpdateFriendRequest $request
     * @param  User                $friend
     * @return boolean
     */
    public function updateExistingFriend(UpdateFriendRequest $request, User $friend)
    {
        if ($request->block) {
        	return $request->user()->blockFriend($friend);
        }

        if ($request->unblock) {
        	return $request->user()->unblockFriend($friend);
        }

        return false;
    }
}