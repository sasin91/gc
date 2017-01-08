<?php

namespace App\Http\Controllers\Chat;

use App\ChatThread;
use App\Transformers\ChatThreadTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThreadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publicThreads = ChatThread::onlyPublic()->get();

        if (request()->user()->hasTeams()) {
            return $publicThreads->merge(ChatThread::forTeam(request()->user()->currentTeam())->get());
        }

        return $publicThreads;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ChatThread  $chatThread
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return (new ChatThreadTransformer)->transform(ChatThread::find($id)->load(['team', 'participants']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ChatThread  $chatThread
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatThread $chatThread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ChatThread  $chatThread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChatThread $chatThread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ChatThread  $chatThread
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatThread $chatThread)
    {
        //
    }
}
