<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() == $user->id) {
            return view('users.edit', ['user' => $user,]);
        } else {
            abort(404);
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show', $data);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        //withメソッドを使用してユーザー編集フラッシュメッセージを記述
        return redirect()->route('user.edit', $user->id)->with('greenMessage', 'ユーザー情報を更新しました。');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        //withメソッドを使用してユーザー退会フラッシュメッセージを記述
        return redirect()->route('posts.index')->with('redMessage', '退会が完了しました');
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = $user->followings()->orderBy('id','desc')->paginate(10);
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        return view('follow.followings' ,$data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = $user->followers()->orderBy('id','desc')->paginate(10);
        $data = [
            'user' => $user,
            'followers' => $followers,
        ];
        return view('follow.followers' ,$data);
    }
}
    