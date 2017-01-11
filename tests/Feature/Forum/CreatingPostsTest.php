<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @group Forum
 */
class CreatingPostsTest extends TestCase
{
	public function testAUserCanCreateAPost()
	{
		$this->disableExceptionHandling();
		
		$category = factory(App\ForumCategory::class)->create();

		$thread = factory(App\ForumThread::class)->create([
			'category_id'	=>	$category->id
		]);

		factory(App\ForumPost::class)->create([
			'thread_id'	=>	$thread->id,
			'title'		=>	'You are wrong !!',
			'content'	=>	'The cake is NOT a lie!'	
		]);

		$this->getJson(
			"api/forum/categories/{$category->id}/threads/{$thread->id}/posts"
		)->assertResponseOk()
		 ->seeJson([
			'title'		=>	'You are wrong !!',
			'content'	=>	'The cake is NOT a lie!'
		]);
	}
}
