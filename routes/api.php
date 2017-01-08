<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group(['middleware' => 'auth:api'], function (Router $route) {
    $route->get('users/search/{nameOrEmail}', 'UsersController@search');
    $route->get('users/online', 'UsersController@onlineList');

    $route->group(['prefix' => 'chat', 'namespace' => 'Chat'], function (Router $route) {
        $route->resource('threads', 'ThreadsController');
        $route->resource('threads.messages', 'Thread\MessagesController');
        $route->resource('threads.participants', 'Thread\ParticipantsController');
    });
});

Route::resource('servers', 'ServersController');

Route::get('news/search/{article}', 'NewsController@search');
Route::resource('news', 'NewsController');

Route::get('news/posts/search/{post}', 'News\PostsController@search');
Route::resource('news.posts', 'News\PostsController');