<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('createMessage', '投稿に成功しました！');
    }

    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        // 変数は配列の形で持っていく
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $data=[
            'post' => $post,
        ];
        if (\Auth::id() == $post->user_id) {
            return view('posts.edit', $data);
        }
        abort(404);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return redirect('/')->with('updateMessage', '投稿を更新しました');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            $post->delete();
        }
        return back();
    }

}