<?php

namespace App\Repositories\Forum;

use App\ForumCategory;
use App\ForumThread;
use App\Repositories\Forum\ForumThreadsRepositoryContract;

/**
 * Class ForumThreadsRepository
 * @package App\Repositories\Forum;
 */
class ForumThreadsRepository implements ForumThreadsRepositoryContract
{
	protected $category;

    public function forCategory($forumCategory)
    {
        $forumCategory = $forumCategory instanceof ForumCategory 
        ?: ForumCategory::findOrFail($forumCategory);

    	$this->category = $forumCategory;

    	return $this;
    }

    public function locked()
    {
 		if ($this->category) {
 			return ForumThread::onlyLocked()
            		->where('category_id',$this->category->id)
            		->get();
 		}

 		return ForumThread::onlyLocked()->get();
    }

    public function all()
    {
    	if ($this->category) {
    		return $this->category->threads;
    	}

    	return ForumThread::all();
    }

    public function create(array $attributes)
    {
    	if (! isset($attributes['author_id'])) {
    		$attributes['author_id'] = request()->user()->id;
    	}

    	if ($this->category) {
    		return $this->category->threads()->save(
    			new ForumThread($attributes)
    		);
    	}

    	return ForumThread::create($attributes);
    }
}