<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = new Post;
        // postテーブルが未実装のため「text」となるかわからない
        // postテーブル実装後、こことPostRequest.phpファイルを修正する
        $post->text = $request->text;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }
}
