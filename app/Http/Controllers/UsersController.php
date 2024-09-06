<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * 「ユーザ詳細への初期遷移、および、タイムライン」の表示
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $posts = $this->postsByUser($user);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];

        return view('users.show', $data);
    }

    /**
     * 「フォロー中」の表示
     */
    public function followings($id)
    {
        $user = User::findOrFail($id);
        $followings = []; // TODO 一旦、空。
        $data = [
            'user' => $user,
            'followings' => $followings,
        ];
        
        return view('users.show', $data);
    }

    /**
     * 「フォロワー」の表示
     */
    public function followers($id)
    {
        $user = User::findOrFail($id);
        $followers = []; // TODO 一旦、空。
        $data = [
            'user' => $user,
            'followers' => $followers,
        ];
        
        return view('users.show', $data);
    }

    /**
     *  削除
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        \DB::transaction(function () use ($user) {
            // 「$user」および、関連モデルのレコードを削除する。
            $this->deleteUserRelations($user);
        });

        return redirect('/');
    }

    //編集
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    
    //更新
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if($request->filled('password')){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return back();
    }
}
