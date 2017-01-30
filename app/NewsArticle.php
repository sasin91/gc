<?php

namespace App;

use App\Tag;
use App\Taggable;
use App\Events\News\{NewsArticleCreated, NewsArticleUpdated, NewsArticleDeleted};
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Watson\Rememberable\Rememberable;

class NewsArticle extends Model
{
    use Searchable, Rememberable;

    protected $fillable = [
        'title','description','body'
    ];

    /**
    * The event map for the model.
    *
    * Allows for object-based events for native Eloquent events.
    *
    * @var array
    */
    protected $events = [
        'created'   =>  NewsArticleCreated::class,
        'updated'   =>  NewsArticleUpdated::class,
        'deleting'  =>  NewsArticleDeleted::class
    ];
    

    public function news()
    {
    	return $this->belongsTo(News::class, 'news_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function videos()
    {
    	return $this->morphMany(Video::class, 'videoable');
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
