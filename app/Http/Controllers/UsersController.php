<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

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
        $user = User::findOrFail($id);
        if (\Auth::check() && \Auth::id() == $id) {
            return view('users.edit', ['user' => $user]);
        }
        abort(404); // デモ画面は、ログイン画面に遷移させていたが、挙動がうまくいかなかったため、404エラーを返すように実装
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request-> name ;
        $user->email = $request-> email ;
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('users.show', ['id' => $user->id]);
    }
}