<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    protected $fillable = [
    	'title',
    	'description',
    	'locked',
    	'pinned',
        'popular'
    ];

    protected $casts = [
    	'locked'	=>	'boolean',
    	'pinned'	=>	'boolean',
        'popular'   =>  'boolean'
    ];

    public function scopePopular($query) 
    {
        return $query->where('popular', true);
    } 

    public function scopeUnpopular($query) 
    {
        return $query->where('popular', false);
    } 

    public function category() 
    {
    	return $this->belongsTo(ForumCategory::class);
    }

    public function author() 
    {
    	return $this->belongsTo(User::class);
    }

    public function posts() 
    {
    	return $this->hasMany(ForumPost::class);
    }
}
