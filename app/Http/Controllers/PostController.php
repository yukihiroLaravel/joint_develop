<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Http\Requests\PostRequest;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        //投稿を新規順に取得
        $posts = Post::with('user')->latest()->paginate(10);
        return view('welcome', ['posts' => $posts,]);
    }

    public function store(PostRequest $request)
    {

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

       // データを保存
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = Auth::id(); 
        $post->image = $imagePath;
        $post->save();
        $redirectUrl = session('redirect_to', route('post.list'));

        return redirect($redirectUrl)->with('success', '投稿しました');
    }

    public function edit($id)
    {
        //現在の認証済みユーザーの取得
        $user = Auth::user();
        $post = Post::findOrFail($id);

        //投稿の所有者と認証済みユーザーが一致しているか確認
        if ($post->user_id !== $user->id) {
            abort(403);
        }

        //セッションにリダイレクト先を保存
        session(['redirect_to' => url()->previous()]);

        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();

        //セッションからリダイレクト先を取得
        $redirectUrl = session('redirect_to', route('post.list'));

        return redirect($redirectUrl)->with('success', '投稿内容を更新しました');
    }

    // ユーザの投稿を削除
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() == $post->user_id) {
            $post->delete();
        }
        return back();
    }

}
