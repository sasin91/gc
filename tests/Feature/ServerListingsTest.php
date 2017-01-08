<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @group Server
 */
class ServerListingsTest extends TestCase
{
	use DatabaseSetup;
	
	public function testAnybodyCanSeeAListingOfAvailableServers()
	{
		factory(App\Server::class)->times(3)->create();

		$this->getJson("/api/servers")
			 ->assertResponseOk()
			 ->assertCount(3, $this->decodeResponseJson());
	}
}
