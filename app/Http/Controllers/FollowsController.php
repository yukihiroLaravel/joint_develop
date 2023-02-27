<?php

namespace App\Http\Controllers;
use App\User;
use App\Post;
use App\Follow;
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
        $followings = $user->followings()->get();
        $posts = Post::query()->whereIn('user_id',\Auth::user()->followings()->pluck('follow_id'))->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user'=>$user,
            'followings'=>$followings,
            'posts'=>$posts,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }

    public function followUsers($id)
    {
        $user = User::findOrFail($id);
        $followUsers = $user->followUsers()->get();
        $posts = Post::query()->whereIn('user_id',\Auth::user()->followUsers()->pluck('user_id'))->orderBy('id','desc')->paginate(10);
        $data = [
            'user'=>$user,
            'posts'=>$posts,

        ];
        $data += $this->userCounts($user);
        return View('users.show',$data);

    }
}
