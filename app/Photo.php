<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Storage;

class Photo extends Model
{
	protected $casts = [
		'photoable_id'	=>	'integer'
	];

	public function getFilenameAttribute()
	{
		return last(explode('/', $this->attributes['path']));
	}

	public function getThumbnailUrlAttribute()
	{
		Image::load($this->attributes['path'])
             ->fit(Manipulations::FIT_FILL, 150, 150)
             ->save(storage_path("app/public/thumbnails/{$this->filename}"));

        return Storage::url("thumbnails/{$this->filename}");
	}

	public function getUrlAttribute()
	{
		return Storage::url("photos/{$this->filename}");
	}

    public function photoable()
    {
    	return $this->morphTo();
    }
}
