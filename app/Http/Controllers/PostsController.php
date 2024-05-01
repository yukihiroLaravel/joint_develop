<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts
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

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        } else {
            abort(403);
        }
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect('/');
    }
    
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }
}
