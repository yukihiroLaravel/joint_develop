<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(9);
        return view('welcome',['posts' => $posts] );
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->with('user')->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];

        return view('users.show', $data);
    }

    // 投稿の編集
    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($post->user_id !== $user->id) {
            abort(403);
        }
        $data = [
            'user' => $user,
            'post' => $post,
        ];

        return view('posts.edit', $data);
    }

    // 投稿の更新
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== $request->user()->id) {
            abort(403);
        }
        $post->content = $request->content;
        $post->save();

        return redirect('/')->with('success', '投稿を更新しました');
    }

    // 投稿の削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== \Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect('/')->with('success', '投稿を削除しました');
    }

}