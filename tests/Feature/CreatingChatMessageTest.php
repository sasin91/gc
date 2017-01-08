<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ChatThread;
use App\ChatMessage;

class CreatingChatMessageTest extends TestCase
{
    use Authentication, DatabaseMigrations;

    public function testAUserCanCreateAMessageInAPublicThread()
    {
        $thread = factory(ChatThread::class)->states(['public'])->create();

        $this->postJson("/api/chat/threads/{$thread->id}/messages", factory(ChatMessage::class)->make(['title' => 'Cheers luv', 'body' => "The cavalry is 'ere!"])->jsonSerialize());
        $this->getJson("/api/chat/threads/{$thread->id}/messages")
             ->seeJson(['title' => 'Cheers luv', 'body' => "The cavalry is 'ere!"]);
    }

    public function testAUserCanPostAMessageInAPrivateThreadTheyAreParticipatingIn()
    {
        $team = \Laravel\Spark\Spark::interact(\Laravel\Spark\Contracts\Interactions\Settings\Teams\CreateTeam::class, [
            $this->user(),
            [
                'name'  =>  'Batman & Co.'
            ]
        ]);

        $thread = factory(ChatThread::class)->states(['private'])->create(['team_id' => $team->id]);

        $this->postJson("/api/chat/threads/{$thread->id}/messages",
            factory(ChatMessage::class)->make(['title' => 'Marked by the dragon.', 'body' => "Ōkami yo, waga teki wo kurae!"])->jsonSerialize()
        );
        $this->getJson("/api/chat/threads/{$thread->id}/messages")
             ->seeJson(['title' => 'Marked by the dragon.', 'body' => "Ōkami yo, waga teki wo kurae!"]);
    }

    public function testAUserCannotPostAMessageInAPrivateThreadTheyAreNotParticipatingIn()
    {
        $thread = factory(ChatThread::class)->states(['private'])->create();

        $this->postJson("/api/chat/threads/{$thread->id}/messages",
            factory(ChatMessage::class)->make(['title' => 'The wolf marks its prey', 'body' => "Ryu ga waga teki wo kurau!"])->jsonSerialize()
        );

        $this->assertResponseStatus(403);

        $this->getJson("/api/chat/threads/{$thread->id}/messages")
            ->dontSeeJson(['title' => 'The wolf marks its prey', 'body' => "Ryu ga waga teki wo kurau!"]);
    }
}
