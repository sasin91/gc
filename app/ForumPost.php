<?php

namespace App;

use App\Events\Forum\ForumPostCreated;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $with = [
        'author', 'tags', 'photos'
    ];

    protected $fillable = [
    	'content'
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $events = [
        'created'   =>  ForumPostCreated::class,
        'updated'   =>  ForumPostUpdated::class,
        'deleting'  =>  ForumPostDeleted::class  
    ];


    public function thread() 
    {
    	return $this->belongsTo(ForumThread::class, 'forum_thread_id');
    }

    public function author() 
    {
    	return $this->belongsTo(User::class);
    }

	public function photos()
    {
    	return $this->morphMany(Photo::class, 'photoable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
