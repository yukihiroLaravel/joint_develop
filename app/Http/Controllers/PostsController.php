<?php

namespace App\Http\Controllers;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        
        return back();
    }

    public function index() {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', ['posts' => $posts]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }
}
