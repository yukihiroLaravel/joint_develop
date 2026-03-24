<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store($id)
    {
        // 投稿の所有者が自分ではない場合のみ「いいね」する
        $post = \App\Post::findOrFail($id);
        if (\Auth::id() != $post->user_id) {
            \Auth::user()->favorite($id);
        }
        
        return back();
    }
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    }
}
