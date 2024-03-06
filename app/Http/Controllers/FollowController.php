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

    public function follows($id)
    {
        $user = User::findOrFail($id);
        $follows = $user->follows()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'follows' => $follows
        ];
        return view('follow.follows', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'followers' => $followers
        ];
        \Session::flash('flash_followers_message','フォローリストに追加されました。');
        return view('follow.followers', $data);
    }
}