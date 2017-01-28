<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $with = [
        'author', 'tags', 'photos'
    ];

    protected $fillable = [
    	'content'
    ];

    public function thread() 
    {
    	return $this->belongsTo(ForumThread::class);
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
