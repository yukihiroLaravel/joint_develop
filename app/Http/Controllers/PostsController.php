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

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|max:140',
        ]);

        // 投稿の保存
        $request->user()->posts()->create([
            'content' => $request->content,
        ]);

        // トップページにリダイレクト
        return back();
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // 自分の投稿かチェック
        if ($request->user()->id === $post->user_id) {
            $request->validate([
                'content' => 'required|max:140',
            ]);

            $post->content = $request->content;
            $post->save();
        }

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
}