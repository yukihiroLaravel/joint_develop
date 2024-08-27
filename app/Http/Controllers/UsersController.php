<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        // $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            // 'posts' => $posts,
        ];
        return view('users.show',$data);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
            // 退会に成功したフラッシュメッセージを設定し、初期画面を表示させる
            return redirect()->route('welcome')->with('status', 'ユーザの退会処理が完了しました。');
        }
        return back()->with('error', 'ユーザの退会処理に失敗しました。<br>再度ログインしてからやり直してください。');
    }
}
