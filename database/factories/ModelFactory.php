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
		'author_id'	=>	function () {
			return factory(App\User::class)->create()->id;
		},
		'title'		=>	$faker->title,
		'synopsis'	=>	$faker->catchPhrase
	];
});

$factory->define(App\NewsPost::class, function ($faker) {
	return [
		'article_id'	=>	function () {
			return factory(App\NewsArticle::class)->create()->id;
		},
		'title'			=>	$faker->catchPhrase,
		'description'	=>	$faker->sentence,
		'body'			=>	$faker->paragraph	
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
        'chat_participant_id' =>  function () {
             return factory(App\ChatParticipant::class)->create()->id;
        } ,

        'title' =>  $faker->catchPhrase,
        'body'  =>  $faker->text
    ];
});

$factory->define(App\ChatParticipant::class, function (Faker\Generator $faker) {
    return [
        'user_id' =>  function () {
             return factory(App\User::class)->create()->id;
        } ,
        'chat_thread_id' =>  function () {
             return factory(App\ChatThread::class)->create()->id;
        } ,
    ];
});

$factory->define(App\ChatThread::class, function (Faker\Generator $faker) {
    return [
        'team_id' =>  function () {
             return factory(App\Team::class)->create()->id;
        } ,

        'topic' =>  $faker->bs
    ];
});

$factory->state(\App\ChatThread::class, 'public', function ($faker) {
    return [
        'isPublic'   =>  true
    ];
});

$factory->state(\App\ChatThread::class, 'private', function ($faker) {
   return [
       'isPublic'   =>  false
   ];
});

