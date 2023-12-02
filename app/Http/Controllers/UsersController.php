<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function edit($id)
    {
        // ユーザ編集画面に表示させる変更前データ
        $user = \Auth::user();
        if (\Auth::check() && \Auth::id() == $id)
            return view('users.edit', ['user'=> $user]);
        else
            abort(404);
    }

    protected function update(UserRequest $request)
    {
        // 更新データ保存
        $user = \Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        //ユーザ詳細画面 実装前のためトップページに画面遷移
        //ユーザ詳細画面 実装後に変更
        return redirect('/');
    }
}
