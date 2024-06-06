<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;

class PostsController extends Controller
{
    public function index()
    {
        $user = User::all();
        $posts = Post::orderBy('id','desc')->paginate(10);
        
        return view('welcome', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = \Auth::id();
        $post->content = $request->content;
        $post->save();
        return back();
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        //withメソッドを使用して投稿削除フラッシュメッセージを記述
        return redirect()->route('posts.index')->with('redMessage', '投稿を削除しました。');
    }

    public function edit($id) 
    {
        $post = Post::findOrFail($id);
        if(\Auth::id() == $post->user_id) {
            return view('posts.edit', ['post' => $post]);
        } else{
            abort(404);
        }
    }

    public function update(PostRequest $request, $id) 
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->save();
        //withメソッドを使用して投稿編集フラッシュメッセージを記述
        return redirect()->route('posts.index')->with('greenMessage','更新が成功しました。'); 
    }
}
