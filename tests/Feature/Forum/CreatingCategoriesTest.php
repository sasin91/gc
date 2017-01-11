<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @group Forum
 */
class CreatingCategoriesTest extends TestCase
{
	use Authentication, DatabaseSetup;

	public function testAUserCanCreateACategory()
	{
		$this->disableExceptionHandling();

		$category = factory(App\ForumCategory::class)
					->make([
						'title'		=>	'Fancy cats & dancing dogs',
						'subTitle'	=>	'Latest flashy thing.'	
					])->jsonSerialize();

		$this->postJson("/api/forum/categories", $category);
		$this->assertResponseOk();

		$this->getJson("/api/forum/categories")
			 ->assertResponseOk()
			 ->seeJson([
				'title'		=>	'Fancy cats & dancing dogs',
				'subTitle'	=>	'Latest flashy thing.'	
			]);
	}
}
