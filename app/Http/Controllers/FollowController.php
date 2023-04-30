<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FollowController extends Controller
{
    public function store($id)
    {
        \Auth::user()->follow($id);
        return back();
    }

    public function destroy($id)
    {
        \Auth::user()->unFollow($id);
        return back();
    }


    //testsors

    public function followings_show($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('id','asc')->paginate(10);

        $data = [
            'user' => $user,
            'followings' => $followings,
        ];

        $data += $this->userCounts($user);

        return view('follow.followings',$data);
    }

    public function followers_show($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('id','asc')->paginate(10);

        $data = [
            'user' => $user,
            'followers' => $followers,
        ];

        $data += $this->userCounts($user);

        return view('follow.follower',$data);
    }

}
