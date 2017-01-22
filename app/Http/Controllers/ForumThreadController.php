<?php

namespace App\Http\Controllers;

use App\ForumThread;
use Illuminate\Http\Request;

class ForumThreadController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api')->only('mine');
	}

   public function index()
   {
      return ForumThread::all();
   }


   public function mine()
   {
      return request()->user()->forumThreads;
      // return ForumThread::where('user_id', request()->user()->id)->get();
   }

	public function latest(int $limit = 10)
	{
      return ForumThread::latest()->take($limit)->get();
	}

	public function popular(int $limit = 10)
	{
   	return ForumThread::popular()->take($limit)->get();
   }


}
