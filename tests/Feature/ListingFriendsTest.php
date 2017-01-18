<?php

namespace Tests;

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

		$friends = factory(\App\User::class)->times(5)->create()
		->map(function ($recipient) {
			return (new Friendship)->fillRecipient($recipient)->fill([
	            'status' => Status::ACCEPTED,
	        ]);
		});	

		$this->user()->friends()->saveMany($friends);

		$request = $this->getJson("/api/friends");
		$request->assertStatus(200);

		$response = json_decode($request->getContent(), true);
        $this->assertCount(5, $response);
	}

	public function testAUserCanSeeTheirPendingFriendRequests()
	{
		$this->disableExceptionHandling();

		$friends = factory(\App\User::class)->times(5)->create()
		->map(function ($recipient) {
			return (new Friendship)->fillRecipient($recipient)->fill([
	            'status' => Status::PENDING,
	        ]);
		});	

		$this->user()->friends()->saveMany($friends);

		$request = $this->getJson("/api/friends/pending");
		$request->assertStatus(200);

        $this->assertCount(5, json_decode($request->getContent()), true);
	}
}
