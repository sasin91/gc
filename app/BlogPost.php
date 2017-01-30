<?php

namespace App;

use App\Events\Blog\{BlogPostCreated, BlogPostUpdated, BlogPostDeleted};
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
    	'title','summary','body'
    ];

    /**
    * The event map for the model.
    *
    * Allows for object-based events for native Eloquent events.
    *
    * @var array
    */
    protected $events = [
        'created'   =>  BlogPostCreated::class,
        'updated'   =>  BlogpostUpdated::class,
        'deleting'  =>  BlogPostDeleted::class 
    ];
    

    public function blog() 
    {
    	return $this->belongsTo(Blog::class);
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
