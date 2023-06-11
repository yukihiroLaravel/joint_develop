<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }
    
    public function showFollowingList($id)
    {
        $user = User::findOrFail($id);
        $followingUsers = $user->following()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'followingUsers' => $followingUsers,
        ];
        $data += $this->userCounts($user);
        return view('follow.following_list', $data);
    }
    
    public function showFollowedList($id)
    {
        $user = User::findOrFail($id);
        $followedUsers = $user->followed()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'followedUsers' => $followedUsers,
        ];
        $data += $this->userCounts($user);
        return view('follow.followed_list', $data);
    }
}
