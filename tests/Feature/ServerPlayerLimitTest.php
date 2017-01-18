<?php

namespace Tests;

use App\Repositories\ServerRepositoryContract;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @group Server
 */
class ServerPlayerLimitTest extends TestCase
{
	use DatabaseSetup, Authentication;

	public function testHasAPlayerLimit()
	{
		$server = factory(\App\Server::class)->create(['player_limit' => 50]);

		$this->getJson("/api/servers/{$server->id}")
			 ->assertStatus(200)
			 ->assertJson(['player_limit' => 50]);
	}

	public function testCanIncreasePlayerLimit()
	{
		// Seed the database records.
		$this->seed();

		$server = factory(\App\Server::class)->create(['player_limit' => 50]);

		$this->asDeveloper()->patchJson("/api/servers/{$server->id}", ['player_limit' => 100]);
		$this->getJson("/api/servers/{$server->id}")
			 ->assertStatus(200)
			 ->assertJson(['player_limit' => 100]);		
	}

	public function testCannotExceedPlayerLimit()
	{
		$this->disableExceptionHandling();

		$server = factory(\App\Server::class)->create(['player_limit' => 0]);

		try {
			resolve(ServerRepositoryContract::class)->join(
				$server, 
				$this->user()
			);
		} catch (\OutOfBoundsException $e) {
			$this->assertEquals(
				"Player limit reached.",
				 $e->getMessage()
			);
		}
	}
}
