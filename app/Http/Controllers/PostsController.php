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

   public function show($id)
   {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(10);
        return view('user.show', [
            'user' => $user,
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
}
