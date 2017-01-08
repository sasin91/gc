<?php

namespace App\Http\Controllers;

use App\NewsArticle;
use App\Http\Requests\{StoreNewsArticleRequest, UpdateNewsArticleRequest};
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
    }

    public function search($article)
    {
        return NewsArticle::search($article)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NewsArticle::with('author')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return (new NewsArticle)->getFillable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsArticleRequest $request)
    {
        NewsArticle::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewsArticle  $newsArticle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return NewsArticle::findOrFail($id)->load(['posts', 'author']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewsArticle  $newsArticle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return NewsArticle::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewsArticle  $newsArticle
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsArticleRequest $request, $id) 
    {
        NewsArticle::findOrFail($id)->update($request->all());  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewsArticle  $newsArticle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        NewsArticle::findOrFail($id)->delete();
    }
}
