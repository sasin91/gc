<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\{NewsArticle, NewsPost, Photo, Video};

/**
 * @group News
 */
class NewsContentTest extends TestCase
{
	use DatabaseMigrations, Authentication;

    public function testUserCanSeeArticleWithPosts()
    {
    	$article = factory(NewsArticle::class)->create(['title'	=>	'hello world']);

		$article->posts()->saveMany(factory(NewsPost::class)->times(3)->make());

		$this->getJson("/api/news/{$article->id}")
			 ->seeJsonContains(['title' => 'hello world'])
			 ->assertCount(3, $article->posts);

	}

	public function testPostCanContainMedia()
	{
		$this->disableExceptionHandling();

		$article = factory(NewsArticle::class)->create(['title' 	=>	'hello world']);
		$post = $article->posts()->save(factory(NewsPost::class)->make());

		$post->photos()->saveMany(factory(Photo::class)->times(3)->make());
		$post->videos()->save(factory(Video::class)->make());

		$this->getJson("/api/news/{$article->id}/posts/{$post->id}")
			 ->seeJsonContains([
			 	'photoable_type' => 'App\NewsPost',
			 	'photoable_id'	 =>	$post->id,
				'videoable_type' => 'App\NewsPost',
				'videoable_id'	 =>	$post->id
			 ])
			 ->assertCount(3, $post->photos);
	}
}
