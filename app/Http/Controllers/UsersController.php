<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{
    //ユーザ詳細ページ
    public function show($id)
    {
        // ユーザ取得（存在しなければ404）
        $user = User::findOrFail($id);

        // そのユーザの投稿一覧を取得
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(9);
        return view('users.show', 
        [
            'user'  => $user,
            'posts' => $posts,
        ]);
    }

    //ユーザ削除
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // ※ 実運用では「本人 or 管理者か」のチェックを入れる
        $user->delete();

        return redirect('/')->with('success', 'ユーザを削除しました。');
    }
}
