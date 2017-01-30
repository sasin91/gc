<?php

namespace App;

use App\Events\Forum\{ForumCreated, ForumUpdated, ForumDeleted};
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
	use Sluggable;

	protected $fillable = [
		'title', 'icon'
	];

	/**
	* The event map for the model.
	*
	* Allows for object-based events for native Eloquent events.
	*
	* @var array
	*/
	protected $events = [
	    'created'	=>	ForumCreated::class,
	    'updated'	=>	ForumUpdated::class,
	    'deleting'	=>	ForumDeleted::class
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
