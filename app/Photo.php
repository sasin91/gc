<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Photo extends Model
{
	protected $casts = [
		'photoable_id'	=>	'integer'
	];

	public function getPathAttribute($path)
	{
		return is_url($path) 
		? $path
		: Storage::url($path);
	}

    public function photoable()
    {
    	return $this->morphTo();
    }
}
