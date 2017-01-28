<?php

use Illuminate\Support\Str;
if (! function_exists('is_url')) {
    /**
     * Determines whether given path is an url.
     * 
     * @param  string  $path
     * @return boolean
     */
    function is_url(string $path)
    {
        return Str::contains($path, ['http://', 'https://']);
    }
}
