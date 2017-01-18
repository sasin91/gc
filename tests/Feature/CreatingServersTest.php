<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Spark\Spark;

/**
 * @group Server
 */
class CreatingServersTest extends TestCase
{
	use DatabaseMigrations, Authentication;

	public function testADeveloperCanCreateAServer()
	{
        $this->seed();

		$this->assertTrue(Spark::developer('jonas.kerwin.hansen@gmail.com'));
		$this->be(\App\User::whereEmail('jonas.kerwin.hansen@gmail.com')->first());

		$this->postJson("/api/servers", 
			factory(\App\Server::class)->make(['name' => 'The playground'])->jsonSerialize()
		)->assertStatus(200);
	}

	public function testAUserCannotCreateAServer()
	{
		$this->be(factory(\App\User::class)->create());

		$this->postJson("/api/servers", 
			factory(\App\Server::class)->make(['name' => 'HellGate'])->jsonSerialize()
		)->assertStatus(401);
	}
}
