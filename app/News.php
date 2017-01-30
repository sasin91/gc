<?php

namespace App;

use App\Events\News\{NewsCreated, NewsUpdated, NewsDeleted};
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class News extends Model
{
	use Searchable;

	protected $fillable = [
		'title', 'synopsis'
	];

    /**
    * The event map for the model.
    *
    * Allows for object-based events for native Eloquent events.
    *
    * @var array
    */
    protected $events = [
        'created'   =>  NewsCreated::class,
        'updated'   =>  NewsUpdated::class,
        'deleting'  =>  NewsDeleted::class
    ];
    

    public function articles()
    {
    	return $this->hasMany(NewsArticle::class);
    }

    public function moderator()
    {
    	return $this->belongsTo(User::class, 'moderator_id');
    }
}
