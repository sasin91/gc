<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NewsPost extends Model
{
    use Searchable;

    public function article()
    {
    	return $this->belongsTo(NewsArticle::class, 'article_id');
    }

    public function videos()
    {
    	return $this->morphMany(Video::class, 'videoable');
    }

    public function photos()
    {
    	return $this->morphMany(Photo::class, 'photoable');
    }
}
