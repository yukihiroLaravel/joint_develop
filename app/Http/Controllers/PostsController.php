<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
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
