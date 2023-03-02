<?php

namespace App\Http\Controllers;
use App\User;
use App\Post;
use Illuminate\Http\Request;

class FollowsController extends Controller
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

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('id','desc')->paginate(10);
        $data = [
            'user'=>$user,
            'followings'=>$followings,
        ];
        $data += $this->userCounts($user);
        return view('users.followings',$data);
    }

    public function followUsers($id)
    {
        $user = User::findOrFail($id);
        $followUsers = $user->followUsers()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user'=>$user,
            'followUsers'=>$followUser,
        ];
        $data += $this->userCounts($user);
        return View('users.followUsers',$data);

    }
}
