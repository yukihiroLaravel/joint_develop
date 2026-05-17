<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;   // 追記
use App\Post;   // 追記
use App\Http\Requests\PostRequest; // 追記

class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $data = [
            'user' => $user,
            'post' => $post,
        ];
        return view('posts.edit', $data);
    }

    public function update(PostRequest $request, $id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->save();
        $data = [
            'user' => $user,
            'post' => $post,
        ];    
        return view('posts.show', $data);
    }

}
