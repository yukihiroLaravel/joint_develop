<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        // ログイン中のユーザと更新対象のユーザが一致するかチェック
        if (\Auth::id() === (int)$id) {
            $user->name = $request->name;
            $user->email = $request->email;
            
            // パスワードが入力された時のみ更新
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            
            $user->save();
        }

        return redirect('/');
    }
}