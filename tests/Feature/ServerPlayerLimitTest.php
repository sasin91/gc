<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @group Server
 */
class ServerPlayerLimitTest extends TestCase
{
	use DatabaseSetup, Authentication;

	public function testHasAPlayerLimit()
	{
		$server = factory(App\Server::class)->create(['player_limit' => 50]);

		$this->getJson("/api/servers/{$server->id}")
			 ->assertResponseOk()
			 ->seeJson(['player_limit' => 50]);
	}

	public function testCanIncreasePlayerLimit()
	{
		// Seed the database records.
		$this->seed();

		$server = factory(App\Server::class)->create(['player_limit' => 50]);

		$this->asDeveloper()->patchJson("/api/servers/{$server->id}", ['player_limit' => 100]);
		$this->getJson("/api/servers/{$server->id}")
			 ->assertResponseOk()
			 ->seeJson(['player_limit' => 100]);		
	}
}
