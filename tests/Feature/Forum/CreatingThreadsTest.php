<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @group Forum
 */
class CreatingThreadsTest extends TestCase
{
	use Authentication, DatabaseSetup;

	public function testAUserCanCreateAThread()
	{
		$this->disableExceptionHandling();
		
		$category = factory(App\ForumCategory::class)->create();

		$this->postJson(
			"/api/forum/categories/{$category->id}/threads",
			factory(App\ForumThread::class)->make([
				'title' 		=> 'Cake & Coffee',
			])->jsonSerialize()
		)->assertResponseOk();

		$this->getJson(
		 "/api/forum/categories/{$category->id}/threads"
		)->assertResponseOk()
		 ->seeJson([
			'title'		=>	'Cake & Coffee',
		]);
	}
}
