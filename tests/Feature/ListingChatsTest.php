<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ChatRoom;

/**
 * @group Chat
 */
class ChatListingTest extends TestCase
{
    use Authentication, DatabaseMigrations;

    public function testAUserCanListAllPublicRooms()
    {
        $this->disableExceptionHandling();

        $visible = factory(ChatRoom::class)->states(['public'])->create(['topic' => 'Latest flashy trends.']);

        $this->getJson('/api/chat/rooms')
             ->assertStatus(200)
             ->assertJson([0 => $visible->jsonSerialize()]);
    }

    public function testAUserCanOnlyListPrivateRoomsTheyShareThroughSparkTeam()
    {
        $this->disableExceptionHandling();

        \Laravel\Spark\Spark::interact(\Laravel\Spark\Contracts\Interactions\Settings\Teams\CreateTeam::class, [
            $this->user(),
            [
                'name'  =>  'Batman & Co.'
            ]
        ]);

        $teamRoom = factory(ChatRoom::class)->states(['private'])->create(['topic' => 'Who ate the last slice of the cake?!', 'team_id' => $this->user()->currentTeam()->id]);

        $this->getJson('/api/chat/rooms')
             ->assertStatus(200)
             ->assertJson([0 => [
                 'id'           =>  $teamRoom->id,
                 'isPublic'     =>  false,
                 'topic'        =>  'Who ate the last slice of the cake?!',
                 'team_id'      =>  $this->user()->currentTeam()->id,
                 'user_id'      =>  null,
                 'created_at'   =>  $teamRoom->created_at->toDateTimeString(),
                 'updated_at'   =>  $teamRoom->updated_at->toDateTimeString(),
                 'participants' =>  $teamRoom->participants->jsonSerialize(),
                 'team'         =>  [
                     'id'                   =>  $this->user()->currentTeam()->id,
                     'owner_id'             =>  $this->user()->currentTeam()->owner_id,
                     'name'                 =>  $this->user()->currentTeam()->name,
                     'slug'                 =>  $this->user()->currentTeam()->slug,
                     'photo_url'            =>  $this->user()->currentTeam()->photo_url,
                     'stripe_id'            =>  $this->user()->currentTeam()->stripe_id,
                     'current_billing_plan' =>  $this->user()->currentTeam()->current_billing_plan,
                     'vat_id'               =>  $this->user()->currentTeam()->vat_id,
                     'trial_ends_at'        =>  $this->user()->currentTeam()->trial_ends_at->toDateTimeString(),
                     'created_at'           =>  $this->user()->currentTeam()->created_at->toDateTimeString(),
                     'updated_at'           =>  $this->user()->currentTeam()->updated_at->toDateTimeString(),
                     'tax_rate'             =>  $this->user()->currentTeam()->tax_rate
                 ]
             ]]);
    }

    public function testARoomHasParticipants()
    {
        $this->disableExceptionHandling();

        $room = factory(ChatRoom::class)->states(['public'])->create([
            'topic' => 'Latest flashy trends.'
        ])->addParticipant($this->user());

        $this->getJson("/api/chat/rooms/{$room->id}")
             ->assertStatus(200)
             ->assertJson([
                 'topic' => 'Latest flashy trends.',
                 'messages' => [],
                 'participants' => [
                     'name' => $this->user()->name
                 ]
             ]);
    }
}
