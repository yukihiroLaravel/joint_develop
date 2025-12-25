<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostsRequest;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
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