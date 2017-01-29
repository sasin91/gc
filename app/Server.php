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

	/**
     * The "booting" method of the model.
     *
     * @return void
     */
	protected static function boot()
	{
		parent::boot();

		static::saving(function ($server) {
			if ($server->players > $server->player_limit) {
				throw new \OutOfBoundsException("Player limit reached.", 422);
			}
		});
	}

	public function players()
	{
		return $this->belongsToMany(User::class);
	}
}
