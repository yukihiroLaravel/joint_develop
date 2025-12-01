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
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show', $data);
    }

    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->save();
        return back();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        // 更新対象のユーザを取得
        $user = User::findOrFail($id);

        // ログイン中のユーザと一致するかチェック
        if (\Auth::id() !== $user->id) {
            return redirect('/')->with('error', '権限がありません');
        }

        // バリデーション
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ]);

        // データ更新
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('user.show', $user->id)
                        ->with('success', 'ユーザ情報を更新しました');
    }
    public function destroy($id)    
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/');
    }
}
