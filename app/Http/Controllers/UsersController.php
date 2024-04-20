<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        // $posts = $user->posts()
        // 取得情報
        // ユーザ（名前、メールアドレス）
        // 投稿（投稿内容、投稿日時）
        $data = ['user'=> $user];
        return view('users.show', $data);
    }

}
