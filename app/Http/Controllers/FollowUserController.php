<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FollowUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class FollowUserController extends Controller
{
    public function exeFollow($id) {
        User::follow($id);
        return redirect(route('users.show', $id));
    }

    public function exeUnfollow($id) {
        User::unfollow($id);
        return redirect(route('users.show', $id));
    }
}
