<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show',$data);
    }

    // ユーザ情報編集画面
    public function edit($userId)
    {
        if (Auth::id() !== (int)$userId) {
            abort(403, 'このユーザは編集権限がありません。');
        }

        $user = User::findOrFail($userId);
        $data = [
            'user' => $user,
        ];
        return view('users.edit', $data);
    }

    // ユーザ情報更新
    public function update(UserRequest $request, $userId)
    {
        if (Auth::id() !== (int)$userId) {
            abort(403, 'このユーザは編集権限がありません。');
        }

        $user = User::findOrFail($userId);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('users.show', $userId);
    }

    // ユーザー退会
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ((\Auth::id() === $user->id)) {
            $user->delete();
        }
        return redirect()->route('posts');
    }
}
