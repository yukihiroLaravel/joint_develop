<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show($id)
    {
        # postテーブルが無い為とりあえずuserのみ実装
        # postテーブル追加後にコメントアウト解除予定
        $user = User::findOrFail($id);
        // $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            // 'posts' => $posts,
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }

}
