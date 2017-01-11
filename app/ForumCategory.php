<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $fillable = [
    	'title', 'subTitle'
    ];

    public function threads()
    {
    	return $this->hasMany(ForumThread::class, 'category_id');
    }
}
