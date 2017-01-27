<?php

namespace App\Http\Controllers\Forum;

use App\Forum;
use App\ForumThread;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\StoreForumThreadRequest;
use App\Http\Requests\Forum\UpdateForumThreadRequest;
use Illuminate\Http\Request;

/**
 * @resource ForumThreads
 */
class ForumThreadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Forum $forum)
    {
        return $forum->threads;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Forum $forum, StoreForumThreadRequest $request)
    {
        $forum->threads()->save(new ForumThread($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function show($forum_id, ForumThread $forumThread)
    {
        return $forumThread->load(['forum', 'author', 'posts']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForumThreadRequest $request,
                           ForumThread $forumThread
    ) {
        $forumThread->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function destroy($forum_id, ForumThread $forumThread)
    {
        $forumThread->delete();
    }
}
