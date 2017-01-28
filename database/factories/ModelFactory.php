<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\NewsArticle::class, function ($faker) {
	return [
        'news_id'       =>  function () {
            return factory(App\News::class)->create()->id;
        },
        'author_id'     =>  function () {
            return factory(App\User::class)->create()->id;
        },
        'title'         =>  $faker->catchPhrase,
        'description'   =>  $faker->sentence,
        'body'          =>  $faker->paragraph   
	];
});

$factory->define(App\News::class, function ($faker) {
	return [
        'moderator_id'  =>  function () {
            return factory(App\User::class)->create()->id;
        },
		'title'       =>  $faker->title,
        'synopsis'  =>  $faker->catchPhrase
	];
});

$factory->define(App\Photo::class, function ($faker) {
	return [	
		'description'	=>	$faker->sentence,	
		'path'			=>	$faker->imageUrl(),
	];
});

$factory->define(App\Video::class, function ($faker) {
	return [
		'title'			=>	$faker->title,
		'description'	=>	$faker->sentence,
		'path'			=>	'video'	
	];
});

$factory->define(App\Team::class, function (Faker\Generator $faker) {
    return [
        'owner_id' =>  function () {
             return factory(App\User::class)->create()->id;
        } ,
        'name' =>  $faker->name ,
        'slug' =>  $faker->word ,
        'photo_url' =>  $faker->text ,
        'stripe_id' =>  $faker->word ,
        'current_billing_plan' =>  $faker->word ,
        'card_brand' =>  $faker->word ,
        'card_last_four' =>  $faker->word ,
        'card_country' =>  $faker->word ,
        'billing_address' =>  $faker->word ,
        'billing_address_line_2' =>  $faker->word ,
        'billing_city' =>  $faker->word ,
        'billing_state' =>  $faker->word ,
        'billing_zip' =>  $faker->word ,
        'billing_country' =>  $faker->countryCode ,
        'vat_id' =>  $faker->word ,
        'extra_billing_information' =>  $faker->text ,
        'trial_ends_at' =>  $faker->dateTimeBetween() ,
    ];
});

$factory->define(App\ChatMessage::class, function (Faker\Generator $faker) {
    return [
        'user_id' =>  function () {
             return factory(App\User::class)->create()->id;
        } ,

        'title' =>  $faker->catchPhrase,
        'body'  =>  $faker->text
    ];
});

$factory->define(App\ChatRoom::class, function (Faker\Generator $faker) {
    return [
//        'team_id' =>  function () {
//             return factory(App\Team::class)->create()->id;
//        } ,

        'topic' =>  $faker->bs
    ];
});

$factory->state(\App\ChatRoom::class, 'public', function ($faker) {
    return [
        'isPublic'   =>  true
    ];
});

$factory->state(\App\ChatRoom::class, 'private', function ($faker) {
   return [
       'isPublic'   =>  false
   ];
});

$factory->define(App\Server::class, function ($faker) {
    return [
        'name'          =>  $faker->name,
        'ip'            =>  $faker->ipv4,
        'map'           =>  $faker->word,
        'game_type'     =>  $faker->word,
        'player_limit'  =>  $faker->numberBetween(5,100),
        'players'       =>  0,
        'MNP'           =>  $faker->word
    ];
});

$factory->define(App\Tag::class, function ($faker) {
    return [
        'name'  =>  $faker->word,
        'label' =>  $faker->randomElement([
            'label label-default',
            'label label-primary',
            'label label-success',
            'label label-info',
            'label label-warning',
            'label label-danger'
        ])
    ];
});

$factory->define(App\Forum::class, function ($faker) {
    return [
        'title' => $faker->title,
    ];
});

$factory->state(App\Forum::class, 'forTeam', function ($faker) {
    return [
        'team_id'   =>  function () {
            return factory(App\Team::class)->create()->id;
        }
    ];
});

$factory->define(App\ForumThread::class, function ($faker) {
    return [
        'forum_id' =>  function () {
            return factory(App\Forum::class)->create()->id;
        },
        'author_id'  =>  function () {
            return factory(App\User::class)->create()->id;
        },

        'title' =>  $faker->title,
        'description'   =>  $faker->bs,
        'pinned'    =>  false,
        'locked'    =>  false,
        'popular'   =>  false,
    ];
});

$factory->state(App\ForumThread::class, 'pinned', function () {
    return [
        'pinned'    =>  true
    ];
});

$factory->state(App\ForumThread::class, 'locked', function () {
    return [
        'locked'    =>  true
    ];
});

$factory->state(App\ForumThread::class, 'popular', function () {
    return [
        'popular'    =>  true
    ];
});

$factory->define(App\ForumPost::class, function ($faker) {
    return [
        'forum_thread_id'   =>  function () {
            return factory(App\ForumThread::class)->create()->id;
        },
        'author_id'  =>  function () {
            return factory(App\User::class)->create()->id;
        },
        'content'   =>  $faker->paragraph
    ];
});