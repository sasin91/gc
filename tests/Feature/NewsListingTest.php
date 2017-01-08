<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\NewsArticle;

class NewsListingTest extends TestCase
{
	use DatabaseMigrations, Authentication;

	public function testUserCanListNews()
	{
		factory(NewsArticle::class)->times(5)->create();

		$this->getJson("/api/news")->assertCount(5, $this->decodeResponseJson());
	}
}
