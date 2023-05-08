<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use App\UserFollow;

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

    public function followingsShow($id)
    {
        $user = User::findOrFail($id);

        $followings = User::select('*')
            ->join('User_Follow','users.id','=','User_Follow.follow_id')
            ->where('user_id','=',$id)
            ->orderBy('user_follow.id','desc')
            ->paginate(10);

        $data = [
            'user' => $user,
            'followings' => $followings,
        ];

        $data += $this->userCounts($user);

        return view('follow.followings',$data);
    }

    public function followersShow($id)
    {
        $user = User::findOrFail($id);

        $followers = User::select('*')
            ->join('User_Follow','users.id','=','User_Follow.user_id')
            ->where('follow_id','=',$id)
            ->orderBy('user_follow.id','desc')
            ->paginate(10);

        $data = [
            'user' => $user,
            'followers' => $followers,
        ];

        $data += $this->userCounts($user);

        return view('follow.follower',$data);
    }

}
