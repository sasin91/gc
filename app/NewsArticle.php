<?php

namespace App;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NewsArticle extends Model
{
	use Taggable, Searchable;

	public function author()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

    public function posts()
    {
    	return $this->hasMany(NewsPost::class, 'article_id');
    }
}
