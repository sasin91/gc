<?php

namespace App;

use App\Events\Blog\{BlogCreated, BlogUpdated, BlogDeleted};
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
    	'name', 'description'
    ];

    /**
    * The event map for the model.
    *
    * Allows for object-based events for native Eloquent events.
    *
    * @var array
    */
    protected $events = [
        'created'   =>  BlogCreated::class,
        'updated'   =>  BlogUpdated::class,
        'deleting'  =>  BlogDeleted::class
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
