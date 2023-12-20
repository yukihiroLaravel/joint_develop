<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    // 投稿削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id){
            $post->delete();
        }
        return back()->with('message', '投稿削除しました！');
    }

    //投稿作成
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:140',
        ]);

        $user = Auth::user(); 

        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = $user->id;
        $post->save();

        return redirect('/posts')->with('success', '投稿が成功しました');
    }
}
