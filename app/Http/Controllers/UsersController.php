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
        $data = [
            'user' => $user,
            'posts' => $posts,
            'users' => collect([]),
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->follows()->paginate(10);
        $data = [
            'user' => $user,
            'users' => $users,
            'posts' => collect([]),
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followed()->paginate(10);
        $data = [
            'user' => $user,
            'users' => $users,
            'posts' => collect([]),
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }
}
