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
}