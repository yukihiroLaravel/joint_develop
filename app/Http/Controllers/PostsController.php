<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->post = $request->post;
        $post->user_id = $request->user()->id;
        $post->save();

        // フラッシュメッセージを設定
        return back()->with('status', '投稿が完了しました。');
    }

    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('status', '投稿を削除しました。');
    }
}