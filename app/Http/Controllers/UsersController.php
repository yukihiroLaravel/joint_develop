<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;

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

    // ユーザ情報編集画面
    public function edit($id)
    {
        // if (Auth::id() !== (int)$id) {
        //     return redirect()->route('login'); // ログインページへ
        // }

        $user = User::findOrFail($id);
        $data = [
            'user' => $user,
        ];
        return view('users.edit', $data);
    }

    // ユーザ情報更新
    public function update(UserRequest $request, $id)
    {

        // if (Auth::id() !== (int)$id) {
        //     return redirect()->route('login'); // ログインページへ
        // }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users.show', $id);
    }
}
