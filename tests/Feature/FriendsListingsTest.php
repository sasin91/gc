<?php

use Hootlex\Friendships\Models\Friendship;
use Hootlex\Friendships\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @group Friends
 */
class FriendsListingsTest extends TestCase
{
	use DatabaseSetup, Authentication;

	public function testAUserCanListTheirFriends()
	{
		$this->disableExceptionHandling();

		$friends = factory(App\User::class)->times(5)->create()
		->map(function ($recipient) {
			return (new Friendship)->fillRecipient($recipient)->fill([
	            'status' => Status::ACCEPTED,
	        ]);
		});	

		$this->user()->friends()->saveMany($friends);

		$this->getJson("/api/friends")
			 ->assertResponseOk()
			 ->assertCount(5, $this->decodeResponseJson());
	}

	public function testAUserCanSeeTheirPendingFriendRequests()
	{
		$this->disableExceptionHandling();

		$friends = factory(App\User::class)->times(5)->create()
		->map(function ($recipient) {
			return (new Friendship)->fillRecipient($recipient)->fill([
	            'status' => Status::PENDING,
	        ]);
		});	

		$this->user()->friends()->saveMany($friends);

		$this->getJson("/api/friends/pending")
		  	 ->assertResponseOk()
		  	 ->assertCount(5, $this->decodeResponseJson());
	}
}
