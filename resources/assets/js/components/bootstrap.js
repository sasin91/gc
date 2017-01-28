
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the Spark components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

require('./../spark-components/bootstrap');

require('./home');

require('./news/news-list');
require('./news/latest-news-list');
require('./news/news-articles-list');
require('./news/show-news-article');

require('./forum');
require('./forum/selected-forum');
require('./forum/forum-thread');
require('./forum/forum-posts');