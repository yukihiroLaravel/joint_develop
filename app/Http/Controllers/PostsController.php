<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request)
    {
        $user = Auth::user();

        $post = new Post;
        $post->user_id = $user->id;
        $post->content = $request->content;
        $post->save();

        return back();
    }
}
