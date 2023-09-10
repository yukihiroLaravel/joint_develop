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
        $user = Auth::user();
        $user->follow($id);
        return back();
    }

    public function exeUnfollow($id) {
        $user = Auth::user();
        $user->unfollow($id);
        return back();
    }
}
