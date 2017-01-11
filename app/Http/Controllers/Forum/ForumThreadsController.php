<?php

namespace App\Http\Controllers\Forum;

use App\ForumCategory;
use App\ForumThread;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\StoreForumThreadRequest;
use App\Http\Requests\Forum\UpdateForumThreadRequest;
use App\Repositories\Forum\ForumThreadsRepository;
use App\Repositories\Forum\ForumThreadsRepositoryContract;
use Illuminate\Http\Request;

class ForumThreadsController extends Controller
{
    /**
     * Forum threads repository
     * @var ForumThreadsRepository
     */
    protected $threads;

    /**
     * ForumThreadsController Constructor
     * 
     * @param ForumThreadsRepositoryContract $repository 
     */
    public function __construct(ForumThreadsRepositoryContract $repository)
    {
        $this->middleware('auth:api')
             ->only(['store', 'update', 'destroy']);

        $this->threads = $repository;
    }

    public function locked($forumCategory)
    {
        return $this->threads
                    ->forCategory($forumCategory)
                    ->locked();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($forumCategory)
    {
        return $this->threads->forCategory($forumCategory)->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreForumThreadRequest $request,
        $forumCategory
    ) {
        $this->threads->forCategory($forumCategory)
                      ->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ForumThread::with(['category', 'author'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateForumThreadRequest $request,
        $forumThread
    ) {
        ForumThread::findOrFail($forumThread)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function destroy($forumThread)
    {
        ForumThread::findOrFail($forumThread)->delete();
    }
}
