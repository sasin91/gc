<?php

namespace App;

use App\ForumThread;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumPost extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'title', 'content'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function thread()
    {
    	return $this->belongsTo(ForumThread::class);
    }
}
