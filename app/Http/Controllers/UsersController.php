<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // 追記
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{   
    //ユーザ詳細
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
        $data=[
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show',$data);
    }

    //ユーザ編集
    public function edit($id) {
        $user = User::findOrFail($id);
        return view('user.edit',['user' =>$user]);
    }

    //ユーザ更新
    public function update(UserRequest $request, $id) {
        if (!empty($request->id)) {
            $user = User::find($request->id);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('welcome');
    }
}