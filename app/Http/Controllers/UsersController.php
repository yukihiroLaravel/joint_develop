<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use App\User;

class UsersController extends Controller
{
<<<<<<< HEAD

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

=======
    
>>>>>>> develop_shimotsuki_rab
    public function edit($id)
    {
        // ユーザ編集画面に表示させる変更前データ
        $user = \Auth::user();
        if ($user->id == $id) {
            return view('users.edit', ['user'=> $user]);
        }
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

    //ユーザー退会
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }
        return back();
    }

}
