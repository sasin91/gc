<?php

namespace App;

use Illuminate\Support\Str;

trait Sluggable {

	public static function bootSluggable()
	{
		static::saving(function ($model) {
			$model->setAttribute('slug', Str::slug($model->{$model->sluggable()}));
		});
	}

	public function sluggable()
	{
		return 'title';
	}
}