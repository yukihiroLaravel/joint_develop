<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // Userモデルを使用

class FollowController extends Controller
{
    // ユーザーをフォローするアクション
    public function store($id)
    {
        // フォロー実行と結果の取得
        $result = auth()->user()->follow($id);
        // フラッシュメッセージなしでページをリダイレクト
        return back();
    }
    // ユーザーのフォローを解除するアクション
    public function destroy($id)
    {
        // アンフォロー実行と結果の取得
        $result = auth()->user()->unfollow($id);
        // フラッシュメッセージなしでページをリダイレクト
        return back();
    }
}