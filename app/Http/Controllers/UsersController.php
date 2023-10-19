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
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            return view('users.edit', ['user' => $user]);
        } else {
            return back();
        }
    }

    // ユーザ情報更新
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
        }

        // 見本ではユーザ詳細画面に飛ばすが、まだないのでTop画面にリダイレクトする。
        return redirect('/');
    }

    // ユーザ詳細画面表示
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show', $data);
    }
}
