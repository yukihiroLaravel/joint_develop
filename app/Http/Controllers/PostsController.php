<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
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
        $post = new Post;
        $post->content = $request->content;
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
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $data=[
            'user' => $user,
            'post' => $post,
        ];
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit', $data);
         }
         return back();
    }
    public function update(PostRequest $request, $id)
    {    
        $post = Post::findOrFail($id);
        $post->user_id = \Auth::id();
        if (\Auth::id() === $post->user_id) {
            $post->user_id = $request->user()->id;
            $post->content = $request->content;
            $post->save();
        }
        return redirect('/');
    }
}
