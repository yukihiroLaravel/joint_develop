<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'content' => ['required', 'string', 'max:140'],
        ]);

        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $user->id;
        $post->save();

        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
}
