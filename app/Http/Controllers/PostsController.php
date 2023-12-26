<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    //投稿一覧表示
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', ['posts'=> $posts]);
    }

    // 投稿削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id){
            $post->delete();
        }
        return back()->with('message', '投稿を削除しました！');
    }
}
