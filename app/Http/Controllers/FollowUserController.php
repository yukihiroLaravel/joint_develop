<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FollowUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class FollowUserController extends Controller
{
    /**
     * followメソッドを呼び出す。
     * @param string $id
     */
    public function exeFollow($id) {
        $user = Auth::user();
        $user->follow($id);
        return back();
    }

    /**
     * unfollowメソッドを呼び出す。
     * @param string $id
     */
    public function exeUnfollow($id) {
        $user = Auth::user();
        $user->unfollow($id);
        return back();
    }
}
