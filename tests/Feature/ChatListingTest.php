<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ChatRoom;

/**
 * @group Chat
 */
class ChatListingTest extends TestCase
{
    use Authentication, DatabaseSetup;

    public function testAUserCanListAllPublicRooms()
    {
        $this->disableExceptionHandling();

        factory(ChatRoom::class)->states(['public'])->create(['topic' => 'Latest flashy trends.']);
        factory(ChatRoom::class)->states(['private'])->create(['topic' => 'Somewhere on Mars they ...']);

        $this->getJson('/api/chat/rooms')
             ->seeJson(['topic' => 'Latest flashy trends.'])
             ->dontSeeJson(['topic' => 'Somewhere on Mars they ...']);
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

        factory(ChatRoom::class)->states(['private'])->create(['topic' => 'Who ate the last slice of the cake?!', 'team_id' => $this->user()->currentTeam()->id]);
        factory(ChatRoom::class)->states(['private'])->create(['topic' => 'Somewhere on Mars they ...']);

        $this->getJson('/api/chat/rooms')
             ->seeJson(['topic' => 'Who ate the last slice of the cake?!'])
             ->dontSeeJson(['topic' => 'Somewhere on Mars they ...']);
    }

    public function testARoomHasParticipants()
    {
        $this->disableExceptionHandling();

        $room = factory(ChatRoom::class)->states(['public'])->create([
            'topic' => 'Latest flashy trends.'
        ])->addParticipant($this->user());

        $this->getJson("/api/chat/rooms/{$room->id}")
            ->seeJson(['topic' => 'Latest flashy trends.'])
            ->seeJson(['name' => $this->user()->name]);
    }
}
