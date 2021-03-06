<?php

namespace App\Http\Controllers\Forum\ForumThread;

use App\Forum;
use App\ForumPost;
use App\ForumThread;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\UpdateForumPostRequest;
use Illuminate\Http\Request;

/**
 * @resource ForumPosts
 */
class ForumPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Forum $forum, ForumThread $thread)
    {
        return $thread->posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($forum_id, ForumThread $forumThread, StoreForumPostRequest $request)
    {
        $forumThread->posts()->save(new ForumPost($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function show($forum_id, $forumThread_id, ForumPost $forumPost)
    {
        return $forumPost->load(['thread', 'author', 'photos', 'tags']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForumPostRequest $request, 
                           $forum_id,
                           $forumThread_id,
                           ForumPost $forumPost
    ) {
        $forumPost->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumPost  $forumPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumPost $forumPost)
    {
        $forumPost->delete();
    }
}
