<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function create()
    {
        $user = \Auth::user();
        // TODO: 投稿一覧表示機能がマージされたらコメントアウトをはずして、投稿画面にも最新の投稿が表示されるようにする
        // $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);

        $data = [
            'user' => $user,
            // TODO: 投稿一覧表示機能がマージされたらコメントアウトをはずして、投稿画面にも最新の投稿が表示されるようにする
            // 'posts' => $posts,
        ];
        return view('posts.create', $data);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->post = $request->post;
        $post->user_id = $request->user()->id;
        $post->save();

        // フラッシュメッセージを設定
        return back()->with('status', '投稿が完了しました。');
    }
}
