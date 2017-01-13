<?php

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

    public function testUserCanSeeNewsWitharticles()
    {
    	$news = factory(News::class)->create(['title'	=>	'hello world']);

		$news->articles()->saveMany(factory(NewsArticle::class)->times(3)->make());

		$this->disableExceptionHandling();

		$this->getJson("/api/news/{$news->id}")
			 ->seeJsonContains(['title' => 'hello world'])
			 ->assertCount(3, $news->articles);

	}

	public function testArticleCanContainMedia()
	{
		$this->disableExceptionHandling();

		$news = factory(News::class)->create(['title' 	=>	'hello world']);
		$article = $news->articles()->save(factory(NewsArticle::class)->make());

		$article->photos()->saveMany(factory(Photo::class)->times(3)->make());
		$article->videos()->save(factory(Video::class)->make());

		$this->getJson("/api/news/{$news->id}/articles/{$article->id}")
			 ->seeJson([
			 	'photoable_type' => 'App\NewsArticle',
			 	'photoable_id'	 =>	$article->id,
				'videoable_type' => 'App\NewsArticle',
				'videoable_id'	 =>	$article->id
			 ])
			 ->assertCount(3, $article->photos);
	}
}
