<?php

namespace App\Http\Controllers;

use App\Post; // 投稿一覧表示用にPostモデルの読み込み
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        // 全投稿を最新順で1ページに10件表示するように取得
        $posts = Post::latest()->paginate(10);

        // 'welcome' ビューに $posts を渡す
        return view('welcome', compact('posts'));
    }
}

public function store(PostRequest $request)
{
    // バリデーション 　　PostRequest のファイルを作る
    $request->validate([
        'content' => 'required|max:140',
    ]);

    //ログインユーザーの投稿として保存
    $request->user()->posts()->create([
        'content' => $request->content,
    ]);

    // 前の画面に戻る
    return back();
}