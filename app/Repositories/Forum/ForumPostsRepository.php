<?php

namespace App\Repositories\Forum;

use App\ForumPost;
use App\ForumThread;
use App\Repositories\Forum\ForumPostsRepositoryContract;

/**
 * Class ForumPostsRepository
 * @package App\Repositories\Forum;
 */
class ForumPostsRepository implements ForumPostsRepositoryContract
{
	protected $thread;

    public function forThread(ForumThread $forumThread)
    {
    	$this->thread = $forumThread;

    	return $this;
    }

    public function create(array $attributes)
    {
    	if (! isset($attributes['user_id'])) {
    		$attributes['user_id'] = request()->user()->id;
    	}

    	if ($this->thread) {
    		return $this->thread
    					->posts()
    					->save(new ForumPost($attributes));
    	}

    	return ForumPost::create($attributes);
    }
}