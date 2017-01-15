<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\StoreNewsArticleRequest;
use App\News;
use App\NewsArticle;
use Illuminate\Http\Request;

class NewsArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(News $news)
    {
        return $news->articles->load(['author', 'tags']);
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
    public function store(StoreNewsArticleRequest $request, News $news)
    {
        $news->articles()->save(new NewsArticle($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NewsArticle  $newsArticle
     * @return \Illuminate\Http\Response
     */
    public function show(News $news, $id)
    {
        return NewsArticle::remember(60)
                          ->findOrFail($id)
                          ->load(['news', 'photos', 'videos', 'author', 'tags']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewsArticle  $newsArticle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news, NewsArticle $article)
    {
        return response()->json($article->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewsArticle  $newsArticle
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news, NewsArticle $article)
    {
        return response()->json($article->delete());
    }
}
