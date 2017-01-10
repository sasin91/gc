<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
	protected $fillable = [
		'name',
		'ip',
		'gameType',
		'player_limit',
		'CNP',
		'MNP'
	];

	protected $casts = [
		'player_limit'	=>	'integer'
	];
}
