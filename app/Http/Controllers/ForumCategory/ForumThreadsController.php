<?php

namespace App\Http\Controllers\ForumCategory;

use App\ForumCategory;
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
    public function index(ForumCategory $forumCategory)
    {
        return $forumCategory->threads;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ForumCategory $forumCategory, StoreForumThreadRequest $request)
    {
        $forumCategory->threads()->save(new ForumThread($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function show($forumCategory_id, ForumThread $forumThread)
    {
        return $forumThread->load(['category', 'author', 'posts']);
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
    public function destroy($forumCategory_id, ForumThread $forumThread)
    {
        $forumThread->delete();
    }
}
