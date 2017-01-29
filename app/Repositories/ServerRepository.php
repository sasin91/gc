<?php

namespace App\Repositories;

use App\Events\Server\{
    PlayerJoined,
    PlayerJoining,
    PlayerLeft,
    PlayerLeaving
};
use App\Repositories\ServerRepositoryContract;
use App\Server;
use App\User;
use Illuminate\Support\Facades\Event;

/**
 * Class ServerRepository
 * @package App\Repositories;
 */
class ServerRepository implements ServerRepositoryContract
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
     * Sets the current User on the Repository.
     * defaults to currently authenticated User.
     *
     * @param  User   $user
     * @return ServerRepositoryContract
     */
    public function forUser(User $user)
    {
    	$this->user = $user;

    	return $this;
    }

    /**
     * Join given Server.
     * 
     * @param  Server    $server
     * @param  User|null $user
     * @return void            
     */
    public function join(Server $server, User $user = null)
    {
    	if ($user) {
    		$this->forUser($user);
    	}

        Event::fire(new PlayerJoining($server, $this->user()));

    	$server->players++;
    	$server->save();
        
    	$this->user()->servers()->attach($server);

        Event::fire(new PlayerJoined($server, $this->user()));
    }

    /**
     * Leave given Server.
     * 
     * @param  Server    $server
     * @param  User|null $user
     * @return void            
     */
    public function leave(Server $server, User $user = null)
    {
    	if ($user) {
    		$this->forUser($user);
    	}

        Event::fire(new PlayerLeaving($server, $this->user()));

    	if (! $this->user()->servers()->contains($server)) {
    		return null;
    	}

    	$server->players--;
    	$server->save();

    	$this->user()->servers()->detach($server);

        Event::fire(new PlayerLeft($server, $this->user()));
    }
}