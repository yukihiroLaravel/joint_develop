<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest; 

class PostsController extends Controller
{
    public function index(PostRequest $request)
    {   
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('welcome',[
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request )
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        $post->save();
        return back();
    }
}
