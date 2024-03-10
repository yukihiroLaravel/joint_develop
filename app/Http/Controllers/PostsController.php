<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
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

    public function store(PostRequest $request) {
        $posts = new Post;
        $posts->content = $request->content;
        $posts->user_id = $request->user()->id;
        $posts->save();
        return back();
    }

    public function edit($id) {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
    
        if (\Auth::check() && \Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        }
        abort(404);
    }

    public function update(PostRequest $request, $id) {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect('/')->with('success', '投稿を更新しました！');
    }

    public function destroy($id) {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $posts = Post::where('content', 'like', "%{$search}%")->paginate(10);
        return view('welcome', compact('posts'));
    }
}
