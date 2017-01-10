<?php

namespace App\Repositories;

use App\Server;
use App\User;

/**
 * Interface ServerRepositoryContract
 * @package App\Repositories;
 */
interface ServerRepositoryContract
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
     * Join given Server.
     * 
     * @param  Server    $server
     * @param  User|null $user
     * @return void            
     */
    public function join(Server $server, User $user = null);

    /**
     * Leave given Server.
     * 
     * @param  Server    $server
     * @param  User|null $user
     * @return void            
     */
    public function leave(Server $server, User $user = null);
}