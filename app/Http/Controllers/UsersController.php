<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Spark\Http\Middleware\VerifyUserIsDeveloper;

/**
 * @resource Users
 */
class UsersController extends Controller
{
    public function onlineList()
    {
        return User::OnlyOnline();
    }

    public function show(User $user)
    {
        return $user->load(['servers', 'blogs', 'friends']);
    }

    public function search(string $nameOrEmail)
    {
        return User::search($nameOrEmail)->get();
    }

    public function friendsList(User $user = null)
    {
        if ($user && $user->id !== request()->user()->id) {
            abort_unless(request()->user()->isDev(), 401);

            return $user->getFriends();
        }

        return request()->user()->getFriends();
    }

    public function messages(User $user = null)
    {
        if ($user && $user->id !== request()->user()->id) {
            abort_unless(request()->user()->isDev(), 401);

            return $user->messages;
        }


        return request()->user()->messages;
    }
}
