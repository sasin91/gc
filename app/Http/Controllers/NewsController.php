<?php

namespace App\Http\Controllers;

use App\News;
use App\Http\Requests\{StoreNewsRequest, UpdateNewsRequest};
use Illuminate\Http\Request;

/**
 * @resource News
 */
class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'update', 'delete']);
    }

    public function search($query)
    {
        return News::search($query)->get();
    }

    public function latest(int $amount = 10)
    {
        return News::orderBy('created_at', 'desc')->take(8)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return News::with('moderator')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return (new News)->getFillable();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsRequest $request)
    {
        News::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $News
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return $news->load(['articles', 'moderator']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $News
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsRequest $request, News $news) 
    {
        $news->update($request->all());  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $News
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();
    }
}
