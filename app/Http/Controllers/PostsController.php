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
        $post->user_id = $request->user()->id;
        // postテーブルが未実装→textか不明(PostRequestも合わせて変更)
        $post->text = $request->text;
        $post->save();
        return back();
    }
}
