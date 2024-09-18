<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\User;

class UsersController extends Controller
{
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
            $user->posts()->delete();
            $user->delete();
            // 退会に成功したフラッシュメッセージを設定し、初期画面を表示させる
            return redirect()->route('welcome')->with('status', 'ユーザの退会処理が完了しました。');
        }
        return back()->with('error', 'ユーザの退会処理に失敗しました。<br>再度ログインしてからやり直してください。');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if ($id == \Auth::id()) {
            return view('users.edit', ['user' => $user]);
        }
        abort(404);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request-> name ;
        $user->email = $request-> email ;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user.show', ['id' => $user->id]);
    }
}