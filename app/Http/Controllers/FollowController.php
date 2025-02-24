<?php

namespace App\Http\Controllers;

use App\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }
    
        $user = User::findOrFail($id);
        \Auth::user()->followings()->attach($user->id);
        return back();
    }

    public function unfollow($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください');
        }
    
        $user = User::findOrFail($id);
        \Auth::user()->followings()->detach($user->id);
    
        return back();
    }

    public function showFollowings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->paginate(10);
    
        return view('users.followings', compact('user', 'followings'));
    }

    public function showFollowers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->paginate(10);
        
        return view('users.followers', compact('user', 'followers'));
    }
}