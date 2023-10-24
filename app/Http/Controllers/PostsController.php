<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function post(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = \Auth::id();
        $post->content = $request->content;
        $post->save();

        return redirect('/');
    }
}