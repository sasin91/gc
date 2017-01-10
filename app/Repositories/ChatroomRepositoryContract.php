<?php

namespace App\Repositories;
use App\ChatRoom;
use App\Team;
use App\User;


/**
 * Class ChatroomRepository
 * @package App\Repositories;
 */
interface ChatroomRepositoryContract
{
    /**
     * Sets the current User on the Repository.
     * defaults to currently authenticated User.
     *
     * @param  User $user
     * @return \App\Repositories\ChatroomRepositoryContract
     */
    public function forUser(User $user);

    public function forTeam(Team $team);

    public function forCurrentTeam();

    public function all();

    public function find($id);

    public function create(array $attributes);

    public function update(ChatRoom $room, array $attributes);

    public function destroy(ChatRoom $room);

    public function onlyPublic();

    public function onlyPrivate();
}