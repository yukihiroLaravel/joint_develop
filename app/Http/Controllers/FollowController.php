<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowController extends Controller
{
    public function store($id)
    {
        $followedUser = User::find($id);
        \Auth::user()->follow($id);
        return redirect('/')->with('followMessage', $followedUser->name . 'をフォローしました');
    }

    public function destroy($id)
    {
        $unfollowedUser = User::find($id);
        \Auth::user()->unfollow($id);
        return redirect('/')->with('UnfollowMessage', $unfollowedUser->name . 'のフォローを解除しました');
    }
}
