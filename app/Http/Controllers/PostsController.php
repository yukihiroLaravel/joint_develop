<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
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

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $data=[
            'user' => $user,
            'post' => $post,
        ];
        return view('posts.edit', $data);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() !== $post->user_id) {
            abort(403);
        }
        $post->content = $request->content;
        $post->save();
        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() !== $post->user_id) {
            abort(403);
        }
        $post->delete();
        return back(); 
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Post::query();

        if (!empty($keyword)) {
            $query->where(function($q) use ($keyword) {
                $q->where('content', 'like', '%' . $keyword . '%');
            });
        }

        $posts = $query->latest()->paginate(10);

        return view('welcome', [
            'posts' => $posts,
            'keyword' => $keyword,   
        ]);
    }    
}