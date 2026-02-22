<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function show($id)
    {
    // 【仮】ログイン機能ができるまでの代わり（今はID 1の人だと仮定）
    $current_user_id = 1; 
    // URLのID ($id) と、仮のログインIDが一致しない場合はエラー
    if ($current_user_id != $id) 
        return abort(403, '他のユーザーのページは見られません');
        
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
        return view('users.edit', ['user' => $user]);
    }

}
