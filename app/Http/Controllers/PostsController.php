<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Http\Requests\PostsRequest;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('reactions')->orderBy('id', 'desc')->paginate(10); //reactionも同時に取得
        return view('welcome', [
            'posts' => $posts,
        ]);
    }

    public function store(PostsRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;

        // 画像アップロード（新規）
        $imagePath = $this->storeImage($request);
        $post->image = $imagePath;

        $post->save();
        return back();
    }

    // 投稿削除
    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);
        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは削除権限がありません。');
        }
        $post->delete();
        return back();
    }

    // 投稿編集画面表示
    public function edit($postId)
    {
        $post = Post::findOrFail($postId);

        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは編集権限がありません。');
        }

        $data = [
            'post' => $post,
        ];
        return view('posts.edit', $data);
    }

    // 投稿更新
    public function update(PostsRequest $request, $postId)
    {
        $post = Post::findOrFail($postId);

        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは編集権限がありません。');
        }

        $post->content = $request->content;

        // 画像アップロード(更新)
        $imagePath = $this->storeImage($request);
        // アップされていれば画像パスを保存、nullの時は何もしない
        if ($imagePath) {
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('posts');
    }

    // 画像アップロード機能：投稿画像ファイルを保存して保存先のパスを返す
    private function storeImage(PostsRequest $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
            return $imagePath;
        }
        return null;
    }
}
