<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Post;


class PostsController extends Controller
{
     public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
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
        if(\Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        } else{
            abort(404);
        }
    }

    public function update(PostRequest $request, $id) 
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->save();
        
        return redirect()->route('posts.index'); 
    }
}
