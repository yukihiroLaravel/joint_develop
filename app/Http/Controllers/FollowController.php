<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // Userモデルを使用

class FollowController extends Controller
{
    // ユーザーをフォローするアクション
    public function store($id)
    {
        $user = User::findOrFail($id); // フォローされるユーザー
        auth()->user()->follow($user); // 現在認証されているユーザーがフォローを実行
        return back(); // 前のページに戻る
    }
    // ユーザーのフォローを解除するアクション
    public function destroy($id)
    {
        $user = User::findOrFail($id); // アンフォローされるユーザー
        auth()->user()->unfollow($user); // 現在認証されているユーザーがフォロー解除を実行
        return back(); // 前のページに戻る
    }
}