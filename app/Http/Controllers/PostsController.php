<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
   {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
   
    }

   public function store(PostRequest $request)
    {
        $user = \Auth::user();
        $post = new Post;
        $post->user_id = $user->id;
        $post->text = $request->text;
        $post->save();
        return back();
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($user->id != $post->user_id) {
            return back();
        }else{
            return view('posts.edit', ['post' => $post]);
        }
    }

    public function update(PostRequest $request, $id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($user->id != $post->user_id) {
            return back();
        }else{
        $post->text = $request->text;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect()->route('welcome');
        }
    }
}