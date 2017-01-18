<?php

namespace Tests;

use Hootlex\Friendships\Models\Friendship;
use Hootlex\Friendships\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use PHPUnit_Framework_Assert as PHPUnit;

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
		$friend = factory(\App\User::class)->create();
		$friend->befriend($this->user());

		$this->putJson("/api/friends/{$friend->id}", [
			'deny'		=>	true
		])->assertStatus(200);
	}

	public function testAUserCanAcceptAFriendRequest()
	{
		
		$friend = factory(\App\User::class)->create();
		$friend->befriend($this->user());

		$this->putJson("/api/friends/{$friend->id}", [
			'accept'	=>	true
		])->assertStatus(200);
	}

	public function testAUserCanBlockAFriend()
	{	
		$friend = factory(\App\User::class)->create();
		$friend->befriend($this->user());

		$this->putJson("/api/friends/{$friend->id}", [
			'block'		=>	true
		])->assertStatus(200);
	}

	public function testAUserCanUnblockAFriend()
	{
		$friendship = (new Friendship)->fillRecipient(
			$pal = factory(\App\User::class)->create()
		)->fill([
			'status'	=>	Status::BLOCKED
		]);	

		$this->user()->friends()->save($friendship);

		$this->putJson("/api/friends/{$pal->id}", [
			'unblock'	=>	true
		])->assertStatus(200);
	}
}
