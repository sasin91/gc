<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
	protected $fillable = [
		'name',
		'ip',
		'player_limit'
	];

	protected $casts = [
		'player_limit'	=>	'integer'
	];
}
