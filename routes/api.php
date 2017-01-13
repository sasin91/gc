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

    $route->group(['prefix' => 'friends'], function (Router $route) {
        $route->get('mutual/{user}', 'FriendsController@mutual');
        $route->get('contains/{user}', 'FriendsController@contains');

        $route->get('denied', 'FriendsController@denied');
        $route->get('blocked', 'FriendsController@blocked');
        $route->get('pending', 'FriendsController@pending');
    });
    
    $route->resource('friends', 'FriendsController');

    $route->group(['prefix' => 'chat', 'namespace' => 'Chat'], function (Router $route) {
        $route->resource('rooms', 'RoomsController');
        $route->resource('rooms.messages', 'Room\MessagesController');
        $route->resource('rooms.participants', 'Room\ParticipantsController');
    });
});

Route::post('servers/join/{server}', 'ServersController@join');
Route::post('servers/leave/{server}', 'ServersController@leave');
Route::resource('servers', 'ServersController');

Route::get('news/search/{query}', 'NewsController@search');
Route::resource('news', 'NewsController');

Route::get('news/articles/search/{query}', 'News\NewsArticlesController@search');
Route::resource('news.articles', 'News\NewsArticlesController');

Route::group(['prefix' => 'forum', 'namespace' => 'Forum'], function() {
    Route::resource('categories', 'ForumCategoriesController');

    Route::get(
        'categories/{category}/threads/locked',
        'ForumThreadsController@locked'
    );
    Route::resource('categories.threads', 'ForumThreadsController');
    Route::resource('categories.threads.posts', 'ForumPostsController');

});