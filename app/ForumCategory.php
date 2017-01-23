<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
	use Sluggable;

	protected $fillable = [
		'title', 'icon'
	];

	public function scopeForTeam($query, $team) 
	{
		return $query->where('team_id', $team);
	}

	public function scopeWithTeam($query, $team) 
	{
	 	return $query->where('team_id', $team)
	 				 ->where('team_id', null);
	} 

	public function team() 
	{
		return $this->belongsTo(Team::class);
	}

	public function threads() 
	{
		return $this->hasMany(ForumThread::class);
	}
}
