<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Transformers\PhotoTransformer;
use Illuminate\Http\Request;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Storage;

class PhotosController extends Controller
{
    /**
     * Bulk load an array of photo ids.
     * 
     * @param  array|string $ids
     * @return \Illuminate\Support\Collection
     */
    public function bulk($ids)
    {
        $ids = is_array($ids) ?: explode(',', $ids);

        return Photo::findOrFail($ids)->map(function (Photo $photo) {
            return (new PhotoTransformer)->transform($photo);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return (new PhotoTransformer)->transform($photo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }
}
