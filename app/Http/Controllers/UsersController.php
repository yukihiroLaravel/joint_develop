<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);

        $countPosts = $user->posts()->count();
        $countFollowings = $user->follows()->count();
        $countFollowers = $user->followed()->count();
        
        return view('users.show', compact('user', 'posts', 'countPosts', 'countFollowings', 'countFollowers'))->with('users', collect([]));
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->follows()->paginate(10);

        $countPosts = $user->posts()->count();
        $countFollowings = $user->follows()->count();
        $countFollowers = $user->followed()->count();
        
        return view('users.show', compact('user', 'users', 'countPosts', 'countFollowings', 'countFollowers'))->with('posts', collect([]));
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followed()->paginate(10);

        $countPosts = $user->posts()->count();
        $countFollowings = $user->follows()->count();
        $countFollowers = $user->followed()->count();
        
        return view('users.show', compact('user', 'users', 'countPosts', 'countFollowings', 'countFollowers'))->with('posts', collect([]));
    }
}
