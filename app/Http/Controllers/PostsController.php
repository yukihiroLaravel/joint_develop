<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(9);

        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request)
    {
            $post = new Post;
            $post->content = $request->content;
            $post->user_id = Auth::id();
            $post->save();
            return back();

        return App::abort(404);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        
        if (Auth::id() === $post->user_id) {
            return view('posts.edit', [
                'post' => $post,
            ]);
        }

        return App::abort(404);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() === $post->user_id) {
            $post->content = $request->content;
            $post->save();
            return redirect("/");
        }

        return App::abort(404);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() === $post->user_id) {            
            $post->forceDelete();
            return redirect("/");
        }

        return App::abort(404);
    }
}
