<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\{News, NewsArticle, Photo, Video};

/**
 * @group News
 */
class NewsContentTest extends TestCase
{
	use DatabaseSetup, Authentication;

    public function testUserCanSeeNewsWithArticles()
    {
    	$news = factory(News::class)->create(['title'	=>	'hello world']);

		$news->articles()->saveMany(factory(NewsArticle::class)->times(3)->make());

		$this->disableExceptionHandling();

		$this->getJson("/api/news/{$news->id}")
             ->assertStatus(200)
			 ->assertJson(['title' => 'hello world']);

	}

	public function testArticleCanContainMedia()
	{
		$this->disableExceptionHandling();

		$news = factory(News::class)->create(['title' 	=>	'hello world']);
		$article = $news->articles()->save(factory(NewsArticle::class)->make());

		$article->photos()->saveMany(factory(Photo::class)->times(3)->make());
		$article->videos()->save(factory(Video::class)->make());

		$this->getJson("/api/news/{$news->id}/articles/{$article->id}")
			 ->assertStatus(200)
             ->assertJson([
                 'photos' => $article->photos->map->jsonSerialize()->toArray(),
             ])
            ->assertJson([
                'videos' => $article->videos->map->jsonSerialize()->toArray()
            ]);
	}
}
