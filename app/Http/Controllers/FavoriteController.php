<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store($id) //ユーザが$idの投稿に対して、いいね！を実行
    {
        \Auth::user()->favorite($id); // 認証されているユーザーが指定した投稿（Post）をお気に入りに追加
        return back(); // 元のページにリダイレクト
    }
    public function destroy($id) //ユーザが$idの投稿に対して、いいね！を解除
    {
        \Auth::user()->unfavorite($id); // 認証されているユーザーが指定した投稿（Post）のお気に入りを解除
        return back();// 元のページにリダイレクト
    }
}
