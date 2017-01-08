<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Spark\Spark;

/**
 * @group Server
 */
class CreatingServersTest extends TestCase
{
	use DatabaseSetup, Authentication;

	public function testADeveloperCanCreateAServer()
	{
		// Empty out the Servers table
		App\Server::truncate();

		$this->seed();

		$this->assertTrue(Spark::developer('jonas.kerwin.hansen@gmail.com'));
		$this->be(App\User::whereEmail('jonas.kerwin.hansen@gmail.com')->first());

		$this->postJson("/api/servers", 
			factory(App\Server::class)->make(['name' => 'The playground'])->jsonSerialize()
		)->assertResponseOk();


		$this->getJson("/api/servers")
			 ->assertResponseOk()
			 ->seeJson(['name' => 'The playground']);
	}

	public function testAUserCannotCreateAServer()
	{
		$this->be(factory(App\User::class)->create());

		$this->postJson("/api/servers", 
			factory(App\Server::class)->make(['name' => 'HellGate'])->jsonSerialize()
		)->assertResponseStatus(401);

		$this->getJson("/api/servers")
			 ->assertResponseOk()
			 ->dontSeeJson(['name' => 'HellGate']);
	}
}
