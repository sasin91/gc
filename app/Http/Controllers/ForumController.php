<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Http\Requests\Forum\StoreForumRequest;
use Illuminate\Http\Request;

/**
 * @resource Forums
 */
class ForumController extends Controller
{
    public function __construct()
    {
        $this->middleware('dev')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return request()->user()
        ? Forum::withTeam(request()->user()->currentTeam())->paginate(10)
        : Forum::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForumRequest $request)
    {
        Forum::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum)
    {
        return $forum->load(['threads', 'team']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForumRequest $request, Forum $forum)
    {
        $forum->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        $forum->delete();
    }
}
