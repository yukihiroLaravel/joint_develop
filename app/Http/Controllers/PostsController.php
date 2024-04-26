<?php

namespace App\Http\Controllers;

use App\User;
use App\Posts;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = \Auth::id();
        $post->content = $request->content;
        $post->save();
        return back();
    }
}
