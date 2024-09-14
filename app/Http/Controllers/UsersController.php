<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show',$data);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->posts()->delete();
            $user->delete();
            // 退会に成功したフラッシュメッセージを設定し、初期画面を表示させる
            return redirect()->route('welcome')->with('status', 'ユーザの退会処理が完了しました。');
        }
        return back()->with('error', 'ユーザの退会処理に失敗しました。<br>再度ログインしてからやり直してください。');
    }

    public function follow($id)
    {
        $user = User::findOrFail($id);
        \Auth::user()->follow($user->id);

        return back()->with('status', $user->name .'さんをフォローしました。');
    }

    public function unfollow($id)
    {
        $user = User::findOrFail($id);
        \Auth::user()->unfollow($user->id);

        return back()->with('status', $user->name .'さんのフォローを解除しました。');
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('updated_at', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'followings' => $followings,
        ];

        return view('users.show', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('updated_at', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'followers' => $followers,
        ];
        return view('users.show', $data);
    }
}