<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
    	'name', 'description'
    ];

    public function posts() 
    {
        return $this->hasMany(BlogPost::class);
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
