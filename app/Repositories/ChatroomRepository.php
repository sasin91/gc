<?php

namespace App\Repositories;

use App\ChatRoom;
use App\Repositories\ChatroomRepositoryContract;
use App\Team;
use App\User;

/**
 * Class ChatroomRepository
 * @package App\Repositories;
 */
class ChatroomRepository implements ChatroomRepositoryContract
{
    /**
	 * The current User.
	 * @var \App\User
	 */
	protected $user;

	/**
	 * The current team.
	 * 
	 * @var \App\Team
	 */
	protected $team;

	/**
	 * The current User.
	 * 
	 * @return User
	 */
	protected function user()
	{
		return $this->user ?? 
			   $this->user = request()->user();
	}

	/**
	 * The current Team.
	 * 
	 * @return Team
	 */
	protected function team()
	{
		return $this->team ??
			   $this->team = $this->user()->currentTeam();
	}

	/**
	 * Parse given attributes
	 * and append missing.
	 * 
	 * @param  array  &$attributes 
	 * @return array
	 */
	protected function parseAttributes(array &$attributes)
	{
		if (! isset($attributes['team_id']) && $this->team()) {
    		$attributes['team_id'] = $this->team()->id;
    	}

    	if (! isset($attributes['user_id']) && $this->user()) {
    		$attributes['user_id'] = $this->user()->id;
    	}

    	return $attributes;
	}

	protected function verifyOwnershipOf(ChatRoom $room)
	{
		if (is_null($room->owner)) {
			abort_unless($room->team->id === $this->team->id,
						 422,
						 "Invalid team."
			);
		}

		abort_unless($room->owner->id === $this->user()->id,
					 403,
					 "You don't own this team."
		);	
	}

	/**
     * Sets the current User on the Repository.
     * defaults to currently authenticated User.
     *
     * @param  User   $user
     * @return ChatroomRepositoryContract
     */
    public function forUser(User $user)
    {
    	$this->user = $user;

    	return $this;
    }

    public function forTeam(Team $team)
    {
    	$this->team = $team;

    	return $this;
    }

    public function forCurrentTeam()
    {
    	$this->team = $this->user()->currentTeam();

    	return $this;
    }

    public function all()
    {
    	if (! $this->user() || ! $this->user()->hasTeams()) {
    		return $this->onlyPublic();
    	}

    	return ChatRoom::forTeam($this->team())
               ->get()
    		   ->load(['users', 'team'])
    		   ->merge($this->onlyPublic());
    }

    public function find($id)
    {
    	return $this->all()->find($id);
    }

    public function create(array $attributes)
    {
    	$this->parseAttributes($attributes);

 		return ChatRoom::create($attributes);
    }

    public function update(ChatRoom $room, array $attributes)
    {
    	$this->verifyOwnershipOf($room);

    	$this->parseAttributes($attributes);

    	return $room->update($attributes);
    }

    public function destroy(ChatRoom $room)
    {
    	$this->verifyOwnershipOf($room);

    	return $room->delete();
    }

    public function onlyPublic()
    {
    	return ChatRoom::onlyPublic()
    					->get()
    					->load('users');
    }

    public function onlyPrivate()
    {
    	return ChatRoom::forTeams(
    		$this->user()->teams
    	)->get()
    	 ->load(['users', 'team']);
    }
}