<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Spatie\Image\Image;

/**
* Image facade for Spatie/Image
*/
class ImageFacade extends Facade
{
	/**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Image::class;
    }	
}