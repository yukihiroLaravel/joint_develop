<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10); 
        return view('welcome', ['posts' => $posts,]);
    }

    public function store(PostRequest $request)
    {
        $user = Auth::user();

        $post = new Post;
        $post->user_id = $user->id;
        $post->content = $request->content;
        $post->save();

        return back();
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $date=[
            'user' => $user,
            'post' => $post,
            'posts' => $posts,
        ];
        return view('posts.edit', $date);
    }
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->user_id = $request->user->id;
        $post->content = $request->content;
        $post->save();
        return back();

    }
}
