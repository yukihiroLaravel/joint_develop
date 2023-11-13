<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use App\User;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        $user = \Auth::user();
        return view('welcome', ['posts' => $posts, 'user' => $user]);    
    }

    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back()->with('status', '投稿しました');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $data=[
                'post' => $post,
            ];
            return view('posts.edit', $data);
        } 
        return back();
    }

    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->content = $request->content;
        $post->save();
        return redirect('/')->with('status', '投稿を編集しました');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (\Auth::id() === $post->user_id) {
            $post->delete();
        }
        return back()->with('status', '投稿を削除しました');
    }
    // フォームの処理
    public function submitForm(Request $request)
    {
      if ($request->session()->has('form_submitted')) {
        // 既にフォームが送信されている場合の処理
        return redirect()->back()->with('error', '二重投稿が検出されました。');
      }

     // フォームの処理

     // セッションにマークを付ける
     $request->session()->put('form_submitted', true);

     return redirect()->route('success')->with('success', 'フォームが正常に送信されました。');
    }

}