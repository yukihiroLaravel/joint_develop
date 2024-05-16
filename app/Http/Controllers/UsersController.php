<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // ユーザ詳細
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $counts = $this->userCounts($user);  // カウント情報を取得
    
        return view('users.show', compact('user', 'posts', 'counts')); // compactを使って配列を作成
    }

    // ユーザがフォローしている他のユーザ一覧を表示
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('created_at', 'desc')->paginate(10);
        $counts = $this->userCounts($user);  // Userモデルの投稿数、フォロー数、フォロワー数を取得
    
        return view('follow.followings', compact('user', 'followings', 'counts'));  // 'counts'を追加
    }

    // フォロワー一覧を表示
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('created_at', 'desc')->paginate(10);
        $counts = $this->userCounts($user);  // Userモデルの投稿数、フォロー数、フォロワー数を取得
    
        return view('follow.followers', compact('user', 'followers', 'counts'));  // 'counts'を追加
    }

    // ユーザ編集画面・更新
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::check() && \Auth::id() == $id) {
            return view('users.edit', ['user' => $user]);
        }
        abort(404); // デモ画面は、ログイン画面に遷移させていたが、挙動がうまくいかなかったため、404エラーを返すように実装
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name ;
        $user->email = $request->email ;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.show', ['id' => $user->id]);
    }
}
