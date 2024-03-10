<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store($id) 
    {
        \Auth::user()->follow($id);
        return back()->with('followedMessage', 'ユーザーをフォローしました');
    }

    public function destroy($id)
    {
        \Auth::user()->unFollow($id);
        return back()->with('unfollowMessage', 'ユーザーをフォローからはずしました');
    }
}
