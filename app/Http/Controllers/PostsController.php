<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Post;
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

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }

    public function edit($id)
    {
    $post = \App\Post::findOrFail($id);
    if (\Auth::id() !== $post->user_id) {
        return redirect('/');
    }
    return view('posts.edit', [
        'post' => $post,
    ]);
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'content' => 'required|max:140',
    ]);
    $post = \App\Post::findOrFail($id);
    if (\Auth::id() === $post->user_id) {
        $post->content = $request->content;
        $post->save();
    }
    return redirect('/');
    }
}
