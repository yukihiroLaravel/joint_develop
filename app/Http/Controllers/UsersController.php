<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // 追記

class UsersController extends Controller
{
    // プロフィール + 投稿一覧
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show',$data);
    }
    
    // フォロー中一覧
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followings()->paginate(10);

        return view('users.followings', [
            'user' => $user,
            'users' => $users,
        ]);
    }

    // フォロワー一覧
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followers()->paginate(10);

        return view('users.followers', [
            'user' => $user,
            'users' => $users,
        ]);
    }
}