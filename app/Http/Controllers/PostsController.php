<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostEditRequest;

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
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if (\Auth::id() === $post->user_id) {
            return view('posts.edit', [
                'user' => $user,
                'post' => $post,
            ]);
        }
        return back();
    }
    public function update(PostEditRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->content = $request->content;
            $post->save();
        }
        return redirect('/');
    }
}