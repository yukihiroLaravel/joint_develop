<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }


    public function edit($id)
    {
        $user = \Auth::user();
        $userFind = User::findOrFail($id);
        $users = $user->orderBy('id', 'desc');
        $data=[
            'user' => $user,
            'userFind' => $userFind,
            'users' => $users,
        ];
        return view('user.edit', $data);
    }
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->user_id = $request->user()->id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return view(''); //ユーザ詳細画面のURL
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->user_id) {
            $user->softDeletes();
        }

        //アラートを表示させる
        return back();
    }

}
