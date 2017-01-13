<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class News extends Model
{
	use Searchable;

	protected $fillable = [
		'title', 'synopsis'
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
