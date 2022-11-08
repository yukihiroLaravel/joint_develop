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
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        return view('welcome', [
            'posts' => $posts,
        ]);
    }


    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = \Auth::id();
        $post->text = $request->text;
        $post->save();

        return redirect(route('home'));
    }

    /**
     * 投稿編集画面の表示
     * @param int $id
     * @return view
     */
    public function showEdit($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $data = [
            'user' => $user,
            'post' => $post,
        ];
        if(\Auth::id() === $post->user_id) {
            return view('posts.edit', $data);
        } else {
            \Session::flash('err_msg', 'アクセス権限がありません。');
            return redirect(route('home'));
        }
    }

    /**
     * 投稿編集を実行
     * @param PostRequest $request
     * @param int $id
     * @return view
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->text = $request->text;
        $post->save();

        return redirect(route('home'));
    }
}
