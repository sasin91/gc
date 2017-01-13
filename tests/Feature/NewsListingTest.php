<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\{NewsPost, NewsArticle};

/**
 * @group News
 */
class NewsListingTest extends TestCase
{
	use DatabaseSetup, Authentication;

	public function testUserCanListNews()
	{
		$this->disableExceptionHandling();

		factory(NewsArticle::class)->times(5)->create();

		$this->getJson("/api/news")->assertCount(5, $this->decodeResponseJson());
	}
}
