<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function post(Request $request, $id)
    {
        $post = new Post;
        $post->user_id = $id;
        $post->content = $request->content;
        $post->save();

        return redirect('/');
    }
}