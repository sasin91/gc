<?php

namespace App;

use App\{
	User,
	ForumPost,
	ForumCategory,
	ForumSubCategory
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumThread extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'title', 'pinned', 'locked',
		'author_id',
	];

	protected $casts = [
		'pinned'	=>	'boolean',
		'locked'	=>	'boolean'
	];

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('lockingScope', function ($query) {
			return $query->where('locked', false);
		});
	}

	public function scopeWithLocked($query)
	{
		return $query->withoutGlobalScope('lockingScope');
	}

	public function scopeOnlyLocked($query)
	{
		return $query->withoutGlobalScope('lockingScope')
					 ->where('locked', true);
	}

	public function scopeForUser($query, $user)
	{
		return $query->where('author_id', $user->id);
	}

	public function author()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

    public function category()
    {
    	return $this->belongsTo(ForumCategory::class, 'category_id');
    }
    
    public function posts()
    {
    	return $this->hasMany(ForumPost::class, 'thread_id');
    }
}
