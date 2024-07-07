<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    //編集画面の表示
    public function edit($id)
    {
        $post = Post::find($id);

        // ユーザー認証チェック
        //if (Auth::id() !== $post->user_id) {
        //    return redirect()->route('top')->with('error', 'アクセス権限がありません。');
        //}

        return view('posts.edit', compact('post'));
    }

    // 投稿編集処理
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        // ユーザー認証チェック
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('top')->with('error', 'アクセス権限がありません。');
        }

        $post->content = $request->content;
        $post->save();

        return redirect()->route('top');
    }
}