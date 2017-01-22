<?php

namespace App\Http\Controllers;

use App\ForumCategory;
use App\Http\Requests\Forum\StoreForumCategoryRequest;
use Illuminate\Http\Request;

class ForumCategoryController extends Controller
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
        ? ForumCategory::withTeam(request()->user()->currentTeam())->get()
        : ForumCategory::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForumCategoryRequest $request)
    {
        ForumCategory::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumCategory  $forumCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ForumCategory $forumCategory)
    {
        return $forumCategory->load(['threads', 'team']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumCategory  $forumCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateForumCategoryRequest $request, ForumCategory $forumCategory)
    {
        $forumCategory->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumCategory  $forumCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ForumCategory $forumCategory)
    {
        $forumCategory->delete();
    }
}
