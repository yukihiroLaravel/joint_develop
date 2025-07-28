<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
    public function edit($id) 
    {
        $post = Post::findOrFail($id);
        if (Auth::id() !== $post->user_id) abort(403);
        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, $id) 
    {
        $post = Post::findOrFail($id);
        if (Auth::id() !== $post->user_id) abort(403);

        $request->validate([
        'content' => 'required|string|max:1000',
    ]);

        $post->content = $request->content;
        $post->save();

        return redirect('/');
    }
}