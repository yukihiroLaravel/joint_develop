<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Post;

class PostsController extends Controller
{
    // コメント追加
    public function index(Request $request, $id)
    {
        // 新規コメントを追加
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $id;
        $post->save();
        // 新たにpostsの一覧を取得
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);

        return view('welcome', ['posts' => $posts]);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->content = $request->content;
        $post->save();
        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return back();
    }

}
