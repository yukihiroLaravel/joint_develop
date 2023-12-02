<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function edit($id)
    {
        // ユーザ編集画面に表示させる変更前データ
        // $user = \Auth::user();
        $user = User::find($id);
        $data=[
            'user'=> $user,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ];
        return view('users.useredit',$data);
    }

    protected function update(UserRequest $request,$id)
    {
        // 更新データ保存
        // $user = \Auth::user();
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        //ユーザ詳細画面 実装前のためトップページに画面遷移
        //ユーザ詳細画面 実装後に変更
        return view("welcome");
    }
}
