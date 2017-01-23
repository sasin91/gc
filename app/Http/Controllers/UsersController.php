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
    public function __construct()
    {
        $this->middleware('dev')->only(['friendsList', 'notifications', 'messages']);
    }

    public function onlineList()
    {
        return User::OnlyOnline();
    }

    public function search(string $nameOrEmail)
    {
        return User::search($nameOrEmail)->get();
    }

    public function friendsList(User $user)
    {
        return $user->getFriends();
    }

    public function notifications(User $user)
    {
        return $user->notifications();
    }

    public function messages(User $user)
    {
        return $user->messages;
    }
}
