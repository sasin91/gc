<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\ChatThread;

class ChatListingTest extends TestCase
{
    use Authentication, DatabaseMigrations;

    public function testAUserCanListAllPublicThreads()
    {
        $this->disableExceptionHandling();

        factory(ChatThread::class)->states(['public'])->create(['topic' => 'Latest flashy trends.']);
        factory(ChatThread::class)->states(['private'])->create(['topic' => 'Somewhere on Mars they ...']);

        $this->getJson('/api/chat/threads')
             ->seeJson(['topic' => 'Latest flashy trends.'])
             ->dontSeeJson(['topic' => 'Somewhere on Mars they ...']);
    }

    public function testAUserCanOnlyListPrivateThreadsTheyShareThroughSparkTeam()
    {
        $this->disableExceptionHandling();

        \Laravel\Spark\Spark::interact(\Laravel\Spark\Contracts\Interactions\Settings\Teams\CreateTeam::class, [
            $this->user(),
            [
                'name'  =>  'Batman & Co.'
            ]
        ]);

        factory(ChatThread::class)->states(['private'])->create(['topic' => 'Who ate the last slice of the cake?!', 'team_id' => $this->user()->currentTeam()->id]);
        factory(ChatThread::class)->states(['private'])->create(['topic' => 'Somewhere on Mars they ...']);

        $this->getJson('/api/chat/threads')
             ->seeJson(['topic' => 'Who ate the last slice of the cake?!'])
             ->dontSeeJson(['topic' => 'Somewhere on Mars they ...']);
    }

    public function testAThreadHasParticipants()
    {
        $this->disableExceptionHandling();

        $thread = factory(ChatThread::class)->states(['public'])->create(['topic' => 'Latest flashy trends.'])->addParticipant($this->user());

        $this->getJson("/api/chat/threads/{$thread->id}")
            ->seeJson(['topic' => 'Latest flashy trends.'])
            ->seeJson(['name' => $this->user()->name]);
    }
}
