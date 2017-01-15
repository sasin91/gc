<?php

namespace App;

use App\Tag;
use App\Taggable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Watson\Rememberable\Rememberable;

class NewsArticle extends Model
{
    use Searchable, Rememberable;

    protected $fillable = [
        'title','description','body'
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
