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
        $data += $this->userCounts($user);
        
        return view('users.following', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'followers' => $followers
        ];
        $data += $this->userCounts($user);
        
        return view('users.follower', $data);
    }
}
