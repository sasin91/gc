<?php

namespace App\Http\Controllers\Forum;

use App\ForumPost;
use App\ForumThread;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Forum\StoreForumPostRequest;
use App\Http\Controllers\Forum\UpdateForumPostRequest;
use App\Http\Requests\Forum\StorePostRequest;
use App\Http\Requests\Forum\UpdatePostRequest;
use App\Repositories\Forum\ForumPostsRepository;
use App\Repositories\Forum\ForumPostsRepositoryContract;
use Illuminate\Http\Request;

class ForumPostsController extends Controller
{
    /**
     * Forum posts repository
     * @var ForumPostsRepository
     */
    protected $posts;

    public function __construct(ForumPostsRepositoryContract $repository)
    {
        $this->middleware('auth:api')
             ->only(['store', 'update', 'destroy']);

        $this->posts = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id, $thread_id)
    {
        return ForumThread::findOrFail($thread_id)->posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreForumPostRequest $request,
        $id
    ) {
        $this->posts->forThread($id)->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumPost  $ForumPost
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ForumThread::wih(['user', 'thread'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumPost  $ForumPost
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateForumPostRequest $request,
        $id
    ) {
        ForumPost::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumPost  $ForumPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ForumPost::findOrFail($id)->delete();
    }
}
