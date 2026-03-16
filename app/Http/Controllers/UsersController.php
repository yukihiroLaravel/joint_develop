<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserUpdateRequest;

class UsersController extends Controller
{

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->paginate(10);

        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show',$data);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // ログイン中のユーザと編集対象のユーザが一致するかチェック
        if (\Auth::id() === (int)$id) {
            return view('users.edit', ['user' => $user]);
        }

        return redirect('/');
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        
        // パスワードが入力された時のみ更新
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        
        $user->save();

        return redirect()->route('user.show', ['id' => $user->id]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // ログイン中のユーザーIDと、削除対象のユーザーIDが一致するかチェック
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        // トップページへリダイレクト
        return redirect('/');
    }
}
