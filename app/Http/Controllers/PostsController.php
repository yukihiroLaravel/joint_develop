<?php

namespace App\Http\Controllers;

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

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'post' => $post,
            'posts' => $posts,
        ];
        return view('posts.edit', $data);
    }
    public function update(PostRequest $request, $id)
    {
        $post = Movie::findOrFail($id);
        $post->title = $request->title;
        $post->user_id = $request->user()->id;
        $post->favorite_flag = $request->favorite_flag ? 1 : 0;
        $post->save();
        return back();
    }

}


