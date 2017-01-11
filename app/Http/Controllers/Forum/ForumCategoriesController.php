<?php

namespace App\Http\Controllers\Forum;

use App\ForumCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\StoreForumCategoryRequest;
use App\Http\Requests\Forum\UpdateForumCategoryRequest;
use Illuminate\Http\Request;

class ForumCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
             ->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ForumCategory::all();
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
        return $forumCategory->load(['threads']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumCategory  $forumCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateForumCategoryRequest $request, 
        ForumCategory $forumCategory
    ) {
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
        $ForumCategory->delete();
    }
}
