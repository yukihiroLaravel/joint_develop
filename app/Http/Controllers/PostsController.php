<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $posts = Post::findOrFail($id);

        return view('posts.edit', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function update(Request $request, $id)
    {
        $posts = Post::findOrFail($id);

        $posts->content = $request->input('content');
        $posts->user_id = $request->user()->id;
        $posts->save();

        return back();
    }
}

