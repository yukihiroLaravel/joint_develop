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
        $posts = Post::orderBy('created_at','desc')->paginate(10);
    
        return view('welcome', ['posts' => $posts]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->text = $request->text;
        $post->user_id = \Auth::id();
        $post->save();
        return back();
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id); 
        if(\Auth::id() === $post->user_id){
            return view('posts.edit', ['post' => $post]);
        }else{
            abort(404);
        };
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if(\Auth::id() === $post->user_id){
            $post->text = $request->text;
            $post->save();
            $posts = Post::orderBy('created_at','desc')->paginate(10);
            view('welcome',['posts' => $posts]);
        }else{
            abort(404);
        }
    }
}