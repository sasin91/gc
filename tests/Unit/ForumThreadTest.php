<?php

namespace Tests\Unit;

use App\Events\Forum\{
	ForumThreadBecamePopular,
 	ForumThreadBecameUnpopular,
 	ForumThreadPinned,
 	ForumThreadUnpinned,
 	ForumThreadLocked,
 	ForumThreadUnlocked
};
use App\ForumThread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\DatabaseSetup;
use Tests\TestCase;

/**
 * @group Forum
 */
class ForumThreadTest extends TestCase
{
	use DatabaseSetup;

    /**
     * @covers ForumThread::popular()
     * @test
     */
    public function testEventsGetsFired()
    {
    	$this->expectsEvents(
    		ForumThreadBecamePopular::class, 
    		ForumThreadBecameUnpopular::class,

    		ForumThreadPinned::class,
    		ForumThreadUnpinned::class,

    		ForumThreadLocked::class,
    		ForumThreadUnlocked::class
    	);

    	$thread = factory(ForumThread::class)->create();
    	    	
    	$thread->becomePopular();
    	$thread->becomeUnpopular();

    	$thread->pin();
    	$thread->unpin();

    	$thread->lock();
    	$thread->unlock();
    }
}
