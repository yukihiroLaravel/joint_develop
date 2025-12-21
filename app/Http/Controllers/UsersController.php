<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UpdateRequest;
use App\Post;

class UsersController extends Controller
{
    // 編集画面
    public function edit($id)
    {
        // ユーザ取得（存在しなければ404）
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));

        // そのユーザの投稿一覧を取得
        $posts = $user->posts()->orderBy('created_at', 'desc')->paginate(9);
        return view('users.show', 
        [
            'user'  => $user,
            'posts' => $posts,
        ]);
    }

    //ユーザ削除
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $user->name = $request->name;
        $user->email = $request->email;

        //　パスワード更新
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // ※ 実運用では「本人 or 管理者か」のチェックを入れる
        $user->delete();
        
        return redirect('/')->with('success', 'ユーザを削除しました。');
    }
}
