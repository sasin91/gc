<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\{TestCase, Authentication, DatabaseSetup};
use App\ChatRoom;
use App\ChatMessage;
use Laravel\Spark\Spark;
use Laravel\Spark\Contracts\Interactions\Settings\Teams\CreateTeam;

/**
 * @group Chat
 */
class CreatingChatMessageTest extends TestCase
{
    use Authentication, DatabaseSetup;

    public function testAUserCanCreateAMessageInAPublicrooms()
    {
        $this->disableExceptionHandling();

        $room = factory(ChatRoom::class)->states(['public'])->create();

        $this->postJson("/api/chat/rooms/{$room->id}/messages", [
            'title' => 'Cheers luv',
            'body' => "The cavalry is 'ere!"
        ])->assertStatus(200);
    }

    public function testAUserCanPostAMessageInPrivateRoomsTheyAreParticipatingIn()
    {
        $team = Spark::interact(CreateTeam::class, [
            $this->user(),
            [
                'name'  =>  'Batman & Co.'
            ]
        ]);

        $rooms = factory(ChatRoom::class)->states(['private'])
                                         ->create(['team_id' => $team->id]);

        $this->postJson("/api/chat/rooms/{$rooms->id}/messages",[
            'title' => 'Marked by the dragon.',
            'body' => "Ōkami yo, waga teki wo kurae!"
        ])->assertStatus(200);
    }

    public function testAUserCannotPostAMessageInAPrivateroomsTheyAreNotParticipatingIn()
    {
        $room = factory(ChatRoom::class)->states(['private'])->create();

        $this->postJson("/api/chat/rooms/{$room->id}/messages",[
            'title' => 'The wolf marks its prey',
            'body' => "Ryu ga waga teki wo kurau!"
        ])->assertStatus(403);
    }
}
