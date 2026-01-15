<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\PostsRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('welcome',['posts' => $posts]);
    }

    // 新規投稿
    public function store(PostsRequest $request)
    {
        $user = \Auth::user();
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $user->id;
        
        // バリデーション
        $request->validate([
            'image' => [
                'nullable',          // 必須チェック
                'image',             // jpg, png, bmp, gif, svg, webp であること
                'max:2048',          // サイズ制限（キロバイト単位。2048KB = 2MB）
                'dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000' // 縦横サイズ
            ],
        ]);

        // 2. 画像があるかどうかをチェック！
         if ($request->hasFile('image')) {
        // 画像がある場合のみ、この中の store() が実行される
        $path = $request->file('image')->store('posts', 'public');
        $post->image_path = $path;
        }
        $post->save();
        return redirect()->back()->with('success', '新規投稿しました');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);

        if ($user->id !== $post->user_id) {abort(404);}

        return view('posts.edit', ['post' => $post,]);
    }

    public function update(PostsRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        if (auth()->id() !== $post->user_id) {abort(404);}

        $post->content = $request->input('content');
        $post->save();
        return back()->with('success', '投稿を更新しました');
    }
}