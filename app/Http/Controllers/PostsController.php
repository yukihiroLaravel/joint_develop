<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    // コメント追加
    public function post(Request $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user_id;

        return view('welcome', ['post' => $post]);
    }
}
