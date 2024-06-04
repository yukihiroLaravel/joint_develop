<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // ユーザが$idの投稿に対して、いいねを実行
    public function store($id)
    {
        \Auth::user()->favorite($id); // 認証されているユーザが指定した投稿をいいねに追加
        return back(); // 元のページにリダイレクト
    }

    // ユーザが$idの投稿に対して、いいね！を解除
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id); // 認証されているユーザが指定した投稿のいいねを解除
        return back(); // 元のページにリダイレクト
    }
}
