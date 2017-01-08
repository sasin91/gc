<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
	protected $casts = [
		'photoable_id'	=>	'integer'
	];

    public function photoable()
    {
    	return $this->morphTo();
    }
}
