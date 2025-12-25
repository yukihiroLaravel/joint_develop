<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostsRequest;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('welcome',['posts' => $posts]);
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($user->id !== $post->user_id) {abort(404);}

        return view('posts.edit', ['post' => $post,]);
    }

    public function update(PostsRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if (auth()->id() !== $post->user_id) {abort(404);}

        $post->content = $request->input('content');
        $post->save();
        return back();
    }
}