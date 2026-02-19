<?php

namespace App\Http\Controllers;

use App\Post; // 投稿一覧表示用にPostモデルの読み込み
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        // 全投稿を最新順で1ページに2件表示するように取得
        $posts = Post::latest()->paginate(2);

        // 'welcome' ビューに $posts を渡す
        return view('welcome', compact('posts'));
    }
}