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
        $request->validate([
            'content' => 'required|max:140',
        ]);

        $request->user()->posts()->create([
            'content' => $request->content,
        ]);

        return back();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (\Auth::id() === $post->user_id) {
            return view('posts.edit', [
                'post' => $post,
            ]);
        }

        return redirect('/');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:140',
        ]);

        $post = Post::findOrFail($id);

        if (\Auth::id() === $post->user_id) {
            $post->content = $request->content;
            $post->save();
        }

        return redirect('/');
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