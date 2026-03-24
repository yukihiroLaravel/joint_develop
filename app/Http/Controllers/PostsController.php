<?php

namespace App\Http\Controllers;

use App\Post; // 投稿一覧表示用にPostモデルの読み込み
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        // 全投稿を最新順で1ページに10件表示するように取得
        $posts = Post::latest()->paginate(10);

        // 'welcome' ビューに $posts を渡す
        return view('welcome', compact('posts'));
    }

    public function store(PostRequest $request)
    {
        //ログインユーザーの投稿として保存
        $request->user()->posts()->create([
            'content' => $request->content,
        ]);

        // 前の画面に戻る
        return back();
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // 自分の投稿かチェック
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }

        return back();
    }

    public function favorites($id)
    {
        // 投稿を取得
        $post = Post::findOrFail($id);
        
        // この投稿を「いいね」したユーザーの一覧をページネーションで取得
        $favoriteUsers = $post->favoriteUsers()->paginate(20);
        
        // 取得したデータをビューに渡す
        return view('posts.favorites', [
            'post' => $post,
            'favoriteUsers' => $favoriteUsers,
        ]);
    }
}