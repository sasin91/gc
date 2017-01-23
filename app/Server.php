<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
	protected $fillable = [
		'name',
		'ip',
		'map',
		'game_type',
		'player_limit',
		'players',
		'MNP'
	];

	protected $casts = [
		'player_limit'	=>	'integer',
		'players'		=>	'integer'
	];

	public function players()
	{
		return $this->belongsToMany(User::class);
	}
}
