<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {   
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('welcome',[
            'posts' => $posts,
        ]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $data = [
            'post' => $post,
        ];

        return view('posts.edit',$data);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->save();
        return redirect('/');
    }
}
