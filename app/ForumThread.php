<?php

namespace App;

use App\Events\Forum\{
    ForumThreadCreated,
    ForumThreadUpdated,
    ForumThreadDeleted
};

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    use Sluggable;

    protected $fillable = [
    	'title',
    	'description',
    	'locked',
    	'pinned',
        'popular'
    ];

    protected $casts = [
    	'locked'	=>	'boolean',
    	'pinned'	=>	'boolean',
        'popular'   =>  'boolean'
    ];

    /**
    * The event map for the model.
    *
    * Allows for object-based events for native Eloquent events.
    *
    * @var array
    */
    protected $events = [
        'created'   =>  ForumThreadCreated::class,
        'updated'   =>  ForumThreadUpdated::class,
        'deleting'  =>  ForumThreadDeleted::class
    ];
    
    protected $with = ['author'];

    public function scopeLocked($query) 
    {
        return $query->where('locked', true);
    }

    public function scopePinned($query) 
    {
        return $query->where('pinned', true);
    } 

    public function scopePopular($query) 
    {
        return $query->where('popular', true);
    }  

    public function becomePopular()
    {
        return $this->setAttribute('popular', true)->save();
    }

    public function becomeUnpopular()
    {
        return $this->setAttribute('popular', false)->save();
    }

    public function pin()
    {
        return $this->setAttribute('pinned', true)->save(); 
    }

    public function unpin()
    {
        return $this->setAttribute('pinned', false)->save(); 
    }

    public function lock()
    {
        return $this->setAttribute('locked', true)->save(); 
    }

    public function unlock()
    {
        return $this->setAttribute('locked', false)->save(); 
    }

    public function forum() 
    {
    	return $this->belongsTo(Forum::class);
    }

    public function author() 
    {
    	return $this->belongsTo(User::class);
    }

    public function posts() 
    {
    	return $this->hasMany(ForumPost::class);
    }
}
