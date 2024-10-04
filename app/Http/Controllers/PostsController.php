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

        // 画像or動画ファイルがアップロードされている場合
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $post->image_path = $path;
        }
        $post->save();

        // フラッシュメッセージを設定
        return back()->with('status', '投稿が完了しました。');
    }

    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        $uploadMaxSize = ini_get('upload_max_filesize');
        $data = [
            'posts' => $posts,
            'uploadMaxSize' => $uploadMaxSize
        ];
        return view('welcome', $data);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('status', '投稿を削除しました。');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        }
        abort(404);
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->post = $request->post;
        $post->save();
        return redirect('/');
    }
}