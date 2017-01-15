<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show');

Route::group(['prefix' => 'news'], function() {
    Route::get('/', function () {
    	return view('news.news-list');
    });

    Route::get('/{news}', function (App\News $news) {
    	return view('news.news-articles-list', ['news' => $news]);
    });

    Route::get('/{news}/articles/{article}', function ($news, $article) {
    	return view('news.articles.show-news-article', [
    		'news_id'	  => $news,
    		'article_id'  => $article
    	]);
    });
});
