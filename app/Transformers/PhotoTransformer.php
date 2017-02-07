<?php

namespace App\Transformers;


use App\Photo;

class PhotoTransformer
{
    public function transform(Photo $photo)
    {
        return [
            'filename'		=>	$photo->filename,
            'thumbnailUrl'	=>	$photo->thumbnailUrl,
            'url'			=>	$photo->url
        ];
    }
}