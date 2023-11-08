<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    // 投稿一覧表示
    public function index()
    {
        $posts = Post::orderBy('id','desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    // 投稿新規作成
    public function post(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = \Auth::id();
        $post->content = $request->content;
        $post->save();

        return redirect('/');
    }

    // 投稿編集画面表示
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $data=[
                'post' => $post,
            ];
            return view('posts.edit', $data);
        }
        return back();
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->content = $request->content;
            $post->save();
        }
        return redirect('/');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back();
    }
}
