<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller

{
    // ユーザ詳細
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user', $user));
    }

    // ユーザ編集画面・更新
    public function edit($id)
    {
        $user = User::find($id);
        if (\Auth::check() && \Auth::id() == $id) {
            return view('users.edit', ['user' => $user]);
        }
        abort(404); // デモ画面は、ログイン画面に遷移させていたが、挙動がうまくいかなかったため、404エラーを返すように実装
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        
        return redirect()->route('users.show', ['user' => $user,]);
    }
}


