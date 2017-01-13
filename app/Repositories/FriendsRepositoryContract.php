<?php

namespace App\Repositories;

use App\Http\Requests\UpdateFriendRequest;
use App\User;
use Hootlex\Friendships\Models\Friendship;
use Illuminate\Support\Collection;

/**
 * Interface FriendsRepositoryContract
 * @package App\Repositories;
 */
interface FriendsRepositoryContract
{
    /**
     * Sets the current User on the Repository.
     * defaults to currently authenticated User.
     * 
     * @param  User   $user
     * @return FriendsRepositoryContract
     */
    public function forUser(User $user);

    /**
     * Whether the current User is friends
     * with given friend.
     * 
     * @param  User   $friend
     * @return boolean
     */
    public function contains(User $friend);

    /**
     * Get pending Friendships
     * 
     * @return Collection
     */
    public function pending();

    /**
     * Get blocked Friendship Requests.
     * @return Collection
     */
    public function blocked();

    /**
     * Get denied Friendship Requests.
     * 
     * @return Collection
     */
    public function denied();

    /**
     * Get accepted Friendships
     * 
     * @return Collection
     */
    public function accepted();

    /**
     * Befriend given User.
     * 
     * @param  User   $friend
     * @return Friendship|boolean
     */
    public function befriend(User $friend);

    /**
     * Remove a Friend from your Friends.
     * 
     * @param  User   $friend
     * @return boolean
     */
    public function unfriend(User $friend);

    /**
     * Block given friend.
     * 
     * @param  User   $friend
     * @return boolean
     */
    public function block(User $friend);

    /**
     * Unblock given friend.
     * 
     * @param  User   $friend
     * @return boolean
     */
    public function unblock(User $friend);

    /**
     * Get the mutual friends between current and given User.
     * 
     * @param  User   $friend
     * @return Collection
     */
    public function mutual(User $friend);

    /**
     * Display the Friendship between the current and given User.
     * 
     * @param  User   $friend
     * @return Friendship
     */
    public function showFriendship(User $friend);

    /**
     * Handle a new Friend.
     * 
     * @param  User $friend
     * @param  bool $negate
     * @return boolean              
     */
    public function updateNewFriend(User $friend, bool $negate = false);

    /**
     * Handle updating an existing Friend.
     * 
     * @param  User $user
     * @param  bool $negate
     * @return boolean
     */
    public function updateExistingFriend(User $friend, bool $negate = false);
}