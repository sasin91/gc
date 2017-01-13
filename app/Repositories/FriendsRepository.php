<?php

namespace App\Repositories;

use App\Http\Requests\UpdateFriendRequest;
use App\Repositories\FriendsRepositoryContract;
use App\User;
use Hootlex\Friendships\Models\Friendship;
use Hootlex\Friendships\Status;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FriendsRepository
 * @package App\Repositories;
 */
class FriendsRepository implements FriendsRepositoryContract
{
	/**
	 * The current User.
	 * @var \App\User
	 */
	protected $user;

	/**
	 * The current User.
	 * 
	 * @return User
	 */
	protected function user()
	{
		return $this->user ?? $this->user = request()->user();
	}

	/**
     * Whether the current User is friends
     * with given friend.
     * 
     * @param  User   $friend
     * @return boolean
     */
    public function contains(User $friend)
    {
    	$this->user()->isFriendWith($friend);
    }

	/**
     * Sets the current User on the Repository.
     * defaults to currently authenticated User.
     *
     * @param  User   $user
     * @return FriendsRepositoryContract
     */
    public function forUser(User $user)
    {
    	$this->user = $user;

    	return $this;
    }

	/**
	 * Get pending Friendships
	 * 
	 * @return Collection
	 */
	public function pending()
	{
		return $this->user()->getPendingFriendships()->load(['sender', 'recipient']);
	}

	/**
	 * Get blocked Friendship Requests.
	 * @return Collection
	 */
	public function blocked()
	{
		return $this->user()->getBlockedFriendships()->load(['sender', 'recipient']);
	}

	/**
	 * Get denied Friendship Requests.
	 * 
	 * @return Collection
	 */
	public function denied()
	{
		return $this->user()->getDeniedFriendships()->load(['sender', 'recipient']);
	}

	/**
	 * Get accepted Friendships
	 * 
	 * @return Collection
	 */
	public function accepted()
	{
		return $this->user()->getFriends();
	}

	/**
	 * Befriend given User.
	 * 
	 * @param  User   $friend
	 * @return Friendship|boolean
	 */
	public function befriend(User $friend)
	{
		return $this->user()->befriend($friend);
	}

	/**
	 * Remove a Friend from your Friends.
	 * 
	 * @param  User   $friend
	 * @return boolean
	 */
	public function unfriend(User $friend)
	{
		if ($this->user()->isFriendWith($friend)) {
			return $this->user()->unfriend($friend);
		}

		return false;
	}

	/**
	 * Block given friend.
	 * 
	 * @param  User   $friend
	 * @return boolean
	 */
	public function block(User $friend)
	{
		return $this->user()->blockFriend($friend)->status === Status::BLOCKED;
	}

	/**
	 * Unblock given friend.
	 * 
	 * @param  User   $friend
	 * @return boolean
	 */
	public function unblock(User $friend)
	{
		if ($this->user()->hasBlocked($friend)) {
			return (bool)$this->user()->unblockFriend($friend);
		}

		return False;
	}

	/**
	 * Accept a given friends Friendship Request.
	 * 
	 * @param  User   $friend
	 * @return boolean         
	 */
	public function accept(User $friend)
	{
		if ($this->user()->hasFriendRequestFrom($friend)) {
			return (bool)$this->user()->acceptFriendRequest($friend);
		}

		return false;
	}

	/**
	 * Deny a given friends Friendship Request.
	 * 
	 * @param  User   $friend
	 * @return boolean         
	 */
	public function deny(User $friend)
	{
		if ($this->user()->hasFriendRequestFrom($friend)) {
			return (bool)$this->user()->denyFriendRequest($friend);
		}

		return false;
	}

	/**
	 * Get the mutual friends between current and given User.
	 * 
	 * @param  User   $friend
	 * @return Collection
	 */
	public function mutual(User $friend)
	{
		return $this->user()->getMutualFriends($friend);
	}

	/**
	 * Display the Friendship between the current and given User.
	 * 
	 * @param  User   $friend
	 * @param  User   $user 
	 * @return Friendship|null
	 */
	public function showFriendship(User $friend, User $user = null)
	{
		if ($this->user()->isFriendWith($friend)) {
            return $this->user()->getFriendship($friend);
        }

        return null;
	}

	/**
	 * Handle a new Friend.
	 * 
	 * @param  User $friend
	 * @param  bool $negate
	 * @return boolean              
	 */
    public function updateNewFriend(User $friend, bool $negate = false)
    {
    	return $negate 
    		? $this->deny($friend)
    		: $this->accept($friend);
    }

    /**
     * Handle updating an existing Friend.
     * 
     * @param  User $user
     * @param  bool $negate
     * @return boolean
     */
    public function updateExistingFriend(User $friend, bool $negate = false)
    {
        return $negate
        	? $this->block($friend)
        	: $this->unblock($friend);
    }
}