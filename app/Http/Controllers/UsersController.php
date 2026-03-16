<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->paginate(10);

        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show',$data);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // ログイン中のユーザーIDと、削除対象のユーザーIDが一致するかチェック
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        // トップページへリダイレクト
        return redirect('/');
    }
}
