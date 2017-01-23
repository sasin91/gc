<?php

namespace App;

use Illuminate\Support\Str;

trait Sluggable {
	protected $sluggable = 'title';

	public static function bootSluggable()
	{
		static::saving(function ($model) {
			$model->setAttribute('slug', Str::slug($model->{$model->sluggable}));
		});
	}
}