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
    $route->get('users/{user}', 'UsersController@show');
    $route->get('users/{user?}/friends', 'UsersController@friendsList');
    $route->get('users/{user?}/messages', 'UsersController@messages');

    $route->group(['prefix' => 'friends'], function (Router $route) {
        $route->get('mutual/{user}', 'FriendsController@mutual');
        $route->get('contains/{user}', 'FriendsController@contains');

        $route->get('denied', 'FriendsController@denied');
        $route->get('blocked', 'FriendsController@blocked');
        $route->get('pending', 'FriendsController@pending');
    });
    
    $route->resource('friends', 'FriendsController');

    $route->group(['prefix' => 'chat', 'namespace' => 'Chat'], function (Router $route) {
        $route->resource('rooms', 'ChatRoomController');
        $route->resource('rooms.messages', 'ChatRoom\ChatMessageController');
    });
});

Route::resource('forums', 'ForumController', ['except' => ['create', 'edit']]);
Route::group(['as' => 'forums.'], function() {
    Route::group(['prefix' => 'forums/threads', 'as' => 'threads.'], function() {
        Route::get('/', 'ForumThreadController@index')->name('index');
        Route::get('mine', 'ForumThreadController@mine')->name('mine');
        Route::get('latest', 'ForumThreadController@latest')->name('latest');
        Route::get('popular', 'ForumThreadController@popular')->name('popular');
    });

    Route::group(['prefix' => 'forums/posts', 'as' => 'posts.'], function() {
        Route::get('/', 'ForumPostController@index')->name('index');
        Route::get('mine', 'ForumPostController@mine')->name('mine');
    });
});

Route::resource('forums.threads', 'Forum\ForumThreadsController', ['except' => ['create', 'edit']]);
Route::resource('forums.threads.posts', 'Forum\ForumThread\ForumPostsController', ['except' => ['create', 'edit']]);

Route::post('servers/join/{server}', 'ServersController@join');
Route::post('servers/leave/{server}', 'ServersController@leave');
Route::resource('servers', 'ServersController');

Route::get('news/latest/{amount?}', 'NewsController@latest');
Route::get('news/search/{query}', 'NewsController@search');
Route::resource('news', 'NewsController');

Route::get('news/articles/search/{query}', 'News\NewsArticlesController@search');
Route::resource('news.articles', 'News\NewsArticlesController');

Route::resource('blogs', 'BlogController', ['except' => ['create', 'edit']]);
Route::resource('blogs.posts', 'Blog\BlogPostController', ['except' => ['create', 'edit']]);

Route::get('photos/{ids}/bulk', 'PhotosController@bulk');
Route::resource('photos', 'PhotosController');