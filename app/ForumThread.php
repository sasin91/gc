<?php

namespace App;

use App\Events\Forum\{
    ForumThreadBecamePopular,
    ForumThreadBecameUnpopular,
    ForumThreadLocked,
    ForumThreadUnlocked,
    ForumThreadPinned,
    ForumThreadUnpinned
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

    protected $with = ['author'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($thread) {
            if ($thread->isDirty('popular')) {
                $event = $thread->popular
                ? ForumThreadBecamePopular::class
                : ForumThreadBecameUnpopular::class;

                broadcast(new $event($thread));
            }

            if ($thread->isDirty('locked')) {
                $event = $thread->locked
                ? ForumThreadLocked::class
                : ForumThreadUnlocked::class;

                broadcast(new $event($thread));
            }

            if ($thread->isDirty('pinned')) {
                $event = $thread->pinned
                ? ForumThreadPinned::class
                : ForumThreadUnpinned::class;

                broadcast(new $event($thread));
            }            
        });
    }

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
