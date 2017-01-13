<?php

use Hootlex\Friendships\Models\Friendship;
use Hootlex\Friendships\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @group Friends
 */
class ManagingFriendshipsTest extends TestCase
{
	use DatabaseSetup, Authentication;

	protected function setUp()
	{
		parent::setUp();
		$this->disableExceptionHandling();
	}

	public function testAUserCanDenyAFriendRequest()
	{
		$friend = factory(App\User::class)->create();
		$friend->befriend($this->user());

		$this->putJson("/api/friends/{$friend->id}", [
			'deny'		=>	true
		])
		->assertResponseOk()
		->getJson("/api/friends/denied")
		->assertResponseOk()
		->seeJson([
			'name'	=>	$friend->name,
            'email' =>  $friend->email
		]);
	}

	public function testAUserCanAcceptAFriendRequest()
	{
		
		$friend = factory(App\User::class)->create();
		$friend->befriend($this->user());

		$this->putJson("/api/friends/{$friend->id}", [
			'accept'	=>	true
		])
		->assertResponseOk()
		->getJson("/api/friends")
		->assertResponseOk()
		->seeJson([
            'name'	=>	$friend->name,
			'email'	=>	$friend->email
		]);
	}

	public function testAUserCanBlockAFriend()
	{	
		$friend = factory(App\User::class)->create();
		$friend->befriend($this->user());

		$this->putJson("/api/friends/{$friend->id}", [
			'block'		=>	true
		])
		->assertResponseOk()
		->getJson("/api/friends/blocked")
		->seeJson([
            'name'	=>	$friend->name,
            'email'	=>	$friend->email
		]);
	}

	public function testAUserCanUnblockAFriend()
	{
		$friendship = (new Friendship)->fillRecipient(
			$pal = factory(App\User::class)->create()
		)->fill([
			'status'	=>	Status::BLOCKED
		]);	

		$this->user()->friends()->save($friendship);

		$this->putJson("/api/friends/{$pal->id}", [
			'unblock'	=>	true
		])
		->assertResponseOk();
	}
}
