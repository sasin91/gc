<?php

namespace App\Http\Controllers;

use App\ForumPost;
use Illuminate\Http\Request;

class ForumPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function mine()
    {
        return request()->user()->forumPosts;
    }

    public function index()
    {
       return ForumPost::all();
    }
}
