<?php

namespace App\Http\Controllers\News;

use App\{NewsArticle, NewsPost};
use App\Http\{
    Controllers\Controller,
    Requests\StoreNewsPostRequest,
    Requests\UpdateNewsPostRequest
};

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
    }

    public function search($post)
    {
        return NewsPost::search($post)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NewsArticle $newsArticle)
    {
        return $newsArticle->posts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return (new NewsPost)->getFillable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreNewsPostRequest $request,
        NewsArticle $newsArticle
    ) {
        $newsArticle->posts()->save(new NewsPost($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewsPost  $newsPost
     * @return \Illuminate\Http\Response
     */ 
    public function show($id)
    {
        return NewsPost::findOrFail($id)->load(['article', 'photos', 'videos']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewsPost  $newsPost
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return NewsPost::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewsPost  $newsPost
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsPostRequest $request, $id) 
    {
        NewsPost::findOrFail($id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewsPost  $newsPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NewsPost::findOrFail($id)->delete();
    }
}
