<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
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
        $post->text = $request->text;
        $post->user_id = \Auth::id();
        $post->save();
        return back()->with('flash_message', '投稿されました。');    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('withdraw_message', '削除しました！');    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit',[
                'post' => $post,
            ]);
        }      
        return back();
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->text = $request->text;
            $post->save();
        }
        return redirect("/");
    }
}    