<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostsRequest;

class PostsController extends Controller
{
    //投稿一覧表示,検索機能
    public function index(Request $request)
    {
        $query = Post::with('reactions');

        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $keyword = mb_convert_kana($keyword, 's');

            $keywordArray = preg_split('/[\s]+/', $keyword);

            $query->where(function ($q) use ($keywordArray) {
                foreach ($keywordArray as $word) {
                    $q->orWhere('content', 'like', "%{$word}%");
                }
            });
        }

        $posts = $query->orderBy('id', 'desc')->paginate(10);

        return view('welcome', ['posts' => $posts, 'keyword' => $keyword]);
    }

    public function store(PostsRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('success', '投稿しました！');
    }

    // 投稿削除
    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);
        if (\Auth::id() !== $post->user_id) {
            abort(403, 'このユーザは削除権限がありません。');
        }
        $post->delete();
        return back()->with('success', '削除しました！');
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
        $post->save();

        return redirect()->route('posts')->with('success', '更新しました！');
    }

    // 投稿詳細表示
    public function show($postId)
    {
        $post = Post::with('user')->findOrFail($postId);

        return view('posts.show', [
            'post' => $post,
        ]);
    }
}
