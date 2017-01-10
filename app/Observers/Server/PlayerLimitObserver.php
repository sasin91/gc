<?php

namespace App\Observers\Server;

use App\Server;

/**
* Server Observer
*/
class PlayerLimitObserver
{
	public function saving(Server $server)
	{
		if ($server->players > $server->player_limit) {
			throw new \OutOfBoundsException("Player limit reached.", 422);
		}
	}
}