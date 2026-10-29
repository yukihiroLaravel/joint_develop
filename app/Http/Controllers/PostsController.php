<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->withCount('likedUsers as likes_count')
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('welcome', [
            'posts' => $posts,
            'likedPostIds' => $this->likedPostIds($posts),
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()
            ->with('user')
            ->withCount('likedUsers as likes_count')
            ->orderBy('id', 'desc')
            ->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
            'likedPostIds' => $this->likedPostIds($posts),
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

    // 表示中の投稿のうち、ログインユーザがいいね!済みの投稿IDを1回のSQLで取得する
    private function likedPostIds($posts)
    {
        if (! Auth::check()) {
            return [];
        }

        return Auth::user()->likes()
            ->whereIn('posts.id', $posts->pluck('id'))
            ->pluck('posts.id')
            ->all();
    }
}