<?php

use Hootlex\Friendships\Status;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * @group Friends
 */
class CreatingFriendshipsTest extends TestCase
{
	use DatabaseSetup, Authentication;

    public function testAUserCanBefriendAnother()
    {
    	//$this->disableExceptionHandling();

    	$pal = factory(App\User::class)->create();

    	$this->postJson("/api/friends", ['user_id' => (int)$pal->id]);

    	$this->assertEquals(Status::ACCEPTED, $pal->acceptFriendRequest($this->user()));

    	$this->assertTrue($pal->getFriends()->contains($this->user()));
    }
}
