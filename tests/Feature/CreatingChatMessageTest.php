<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ChatRoom;
use App\ChatMessage;

/**
 * @group Chat
 */
class CreatingChatMessageTest extends TestCase
{
    use Authentication, DatabaseMigrations;

    public function testAUserCanCreateAMessageInAPublicrooms()
    {
        $rooms = factory(ChatRoom::class)->states(['public'])->create();

        $this->postJson("/api/chat/rooms/{$rooms->id}/messages", factory(ChatMessage::class)->make(['title' => 'Cheers luv', 'body' => "The cavalry is 'ere!"])->jsonSerialize())->assertStatus(200);
    }

    public function testAUserCanPostAMessageInPrivateRoomsTheyAreParticipatingIn()
    {
        $team = \Laravel\Spark\Spark::interact(\Laravel\Spark\Contracts\Interactions\Settings\Teams\CreateTeam::class, [
            $this->user(),
            [
                'name'  =>  'Batman & Co.'
            ]
        ]);

        $rooms = factory(ChatRoom::class)->states(['private'])->create(['team_id' => $team->id]);

        $this->postJson("/api/chat/rooms/{$rooms->id}/messages",
            factory(ChatMessage::class)->make(['title' => 'Marked by the dragon.', 'body' => "Ōkami yo, waga teki wo kurae!"])->jsonSerialize()
        )->assertStatus(200);
    }

    public function testAUserCannotPostAMessageInAPrivateroomsTheyAreNotParticipatingIn()
    {
        $room = factory(ChatRoom::class)->states(['private'])->create();

        $this->postJson("/api/chat/rooms/{$room->id}/messages",
            factory(ChatMessage::class)->make(['title' => 'The wolf marks its prey', 'body' => "Ryu ga waga teki wo kurau!"])->jsonSerialize()
        )->assertStatus(403);
    }
}
