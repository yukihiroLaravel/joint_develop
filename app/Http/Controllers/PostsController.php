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
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        // 今後実装予定
        // $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            // 'posts' => $posts,
        ];

        return view('users.show', $data);
    }
    // 投稿の編集
    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
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

        if($post->user_id !== $request->user()->id){
            abort(403);
        }
        $post->content = $request->content;
        $post->save();

        return redirect('/')->with('success', '投稿を更新しました');
    }
}