<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests\UserRequest;
use App\User;

use App\Post;
//use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
//ユーザ編集
    public function edit($id)
    {
        if ($user = \Auth::user()) {
            $user = User::findOrFail($id);
            return view('users.edit', ['user' => $user]);
        } 
        else {
            return redirect('/');
            //return view('user.show', $user);  //### ユーザ詳細が作成され次第、こちらに変更予定
        }
    }

//ユーザ更新
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return back();
        //return view('user.show', $user);  //### ユーザ詳細が作成され次第、こちらに変更予定
    }
}