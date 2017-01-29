<?php

namespace Tests\Unit;

use App\Repositories\ServerRepositoryContract;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Authentication;
use Tests\DatabaseSetup;
use Tests\TestCase;

/**
 * @group Server
 */
class ServerPlayerLimitTest extends TestCase
{
	use DatabaseSetup, Authentication;

	public function testCanIncreasePlayerLimit()
	{
		// Seed the database records.
		$this->seed();

		$server = factory(\App\Server::class)->create(['player_limit' => 50]);

		$this->assertTrue($server->update(['player_limit' => 100]));
		$this->assertEquals(100, $server->player_limit);
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
