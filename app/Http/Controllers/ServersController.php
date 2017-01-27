<?php

namespace App\Http\Controllers;

use App\Formatters\DataStringFormatter;
use App\Http\Requests\Server\{StoreServerRequest, UpdateServerRequest};
use App\Repositories\ServerRepository;
use App\Repositories\ServerRepositoryContract;
use App\Server;
use Illuminate\Http\Request;

/**
 * @resource Servers
 */
class ServersController extends Controller
{
    /**
     * Servers Repository
     * @var ServerRepository
     */
    protected $servers;

    /**
     * ServersController Constructor.
     * 
     * @param ServerRepositoryContract $repository 
     */
    public function __construct(ServerRepositoryContract $repository)
    {
        $this->middleware('dev')->only(['store', 'update', 'destroy']);
        $this->middleware('auth:api')->except(['index', 'show']);

        $this->servers = $repository;
    }

    /**
     * Join a Server as the current User.
     * 
     * @param  Server $server
     * @return void
     */
    public function join(Server $server)
    {
        $this->servers->join($server);
    }

    /**
     * Leave a Server as the current User
     * 
     * @param  Server $server
     * @return void         
     */
    public function leave(Server $server)
    {
        $this->servers->leave($server);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Server::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServerRequest $request)
    {
        Server::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        return $server;
        //return (new DataStringFormatter)->format($server->jsonSerialize());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServerRequest $request, Server $server)
    {
        $server->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function destroy(Server $server)
    {
        $server->delete();
    }
}
