<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\PostRequest;

class PostsController extends Controller

{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return view('welcome', ['posts' => $posts]);
    }

    public function store(PostRequest $request)
    {

        $post = new Post;
        $post->text = $request->text;
        $post->user_id = \Auth::id();
        $post->save();

        return back()->with('successMessage', '新規投稿が完了されました。');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
            return back()->with('successMessage', '投稿を削除しました');
        }
        return back();
    }
}
