<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller

// ユーザ編集画面・更新
{
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        // ユーザ情報の更新処理を追加する
        $user->save();

        return view('users.posts', compact('user', $user));
    }
}
