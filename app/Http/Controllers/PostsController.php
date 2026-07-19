<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Http\Requests\PostsRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('reactions')->orderBy('id', 'desc')->paginate(10); //reactionも同時に取得
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function store(PostsRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }

    // 投稿削除
    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);
        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは削除権限がありません。');
        }
        $post->delete();
        return back();
    }

    // 投稿編集画面表示
    public function edit($postId)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($postId);

        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは編集権限がありません。');
        }

        $data = [
            'user' => $user,
            'post' => $post,
            'from' => url()->previous(),
        ];
        return view('posts.edit', $data);
    }

    // 投稿更新
    public function update(PostsRequest $request, $postId)
    {
        $post = Post::findOrFail($postId);

        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは編集権限がありません。');
        }

        $post->content = $request->content;
        $post->save();

        return redirect($request->input('from', route('posts'))); // 編集前の画面に戻る
    }
}
