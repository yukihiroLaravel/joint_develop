<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use App\User;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    // 投稿一覧表示(ページネイト含む)
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        $user = \Auth::user();
        return view('welcome', ['posts' => $posts, 'user' => $user]);    
    }
    // 投稿
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->youtube_id = $request->youtube_id;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('status', '投稿しました');
    }
    // 投稿編集画面遷移
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $data =[
            'post' => $post,
            'id' => $id,
        ];
        if (\Auth::id() === $post->user_id) {
            return view('posts.edit', $data);
        } else {
            return redirect('/');
        }
    }
    // 投稿編集
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->youtube_id = $request->youtube_id;
        $post->content = $request->content;
        $post->save();
        return redirect('/')->with('status', '投稿を編集しました');
    }
    // 投稿削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('status', '投稿を削除しました');
    }
}