<?php

namespace App\Transformers;


use App\Blog;
use App\Transformers\PhotoTransformer;

class BlogTransformer
{
    public static function transform(Blog $blog)
    {
        return [
           	'name'			=>	$blog->name,
           	'description'	=>	$blog->description,
           	'posts'			=>	$blog->posts,
           	'author'		=>	$blog->author,
           	'tags'			=>	$blog->tags,
           	'photos'		=>	$blog->photos->map(function ($photo) {
           		return (new PhotoTransformer)->transform($photo);
           	})
        ];
    }
}