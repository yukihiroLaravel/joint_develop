<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;

class UsersController extends Controller
{
    // ユーザ編集画面表示
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', ['user' => $user]);

    }

    // ユーザ情報更新
    public function update(UserRequest $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt('$request->password');
        $user->save();
        // 見本ではユーザ詳細画面に飛ばすが、まだないのでTop画面にリダイレクトする。
        return redirect('/');
    }
}
