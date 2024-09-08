<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    /**
     * トップページの投稿表示
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = \Auth::id();
        $post->content = $request->content;
        $post->save();
        return back();
    }
}
