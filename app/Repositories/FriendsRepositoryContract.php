<?php

namespace App\Repositories;

use App\Http\Requests\UpdateFriendRequest;
use App\User;

/**
 * Interface FriendsRepositoryContract
 * @package App\Repositories;
 */
interface FriendsRepositoryContract
{
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
     * Get the mutual friends between current and given User.
     * 
     * @param  User   $friend
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function mutual(User $friend);

    /**
     * Display the Friendship between the current and given User.
     * 
     * @param  User   $user
     * @return Friendship|null
     */
    public function showFriendship(User $user);

    /**
	 * Handle a new Friend.
	 * 
	 * @param  UpdateFriendRequest $request
	 * @param  User                $user   
	 * @return boolean              
	 */
    public function updateNewFriend(UpdateFriendRequest $request, User $user);

    /**
     * Handle updating an existing Friend.
     * 
     * @param  UpdateFriendRequest $request
     * @param  User                $user
     * @return boolean
     */
    public function updateExistingFriend(UpdateFriendRequest $request, User $user);
}