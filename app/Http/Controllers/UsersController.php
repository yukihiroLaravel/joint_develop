<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // 追記
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{   
    //ユーザ詳細
   public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $tab = $request->get('tab', 'posts'); // posts / followings / followers

        if ($tab === 'followings') {
            $users = $user->followings()->paginate(10);
            $posts = null;
        } elseif ($tab === 'followers') {
            $users = $user->followers()->paginate(10);
            $posts = null;
        } else {
            $posts = $user->posts()->orderBy('id', 'desc')->paginate(9);
            $users = null;
        }

        return view('users.show', [
            'user' => $user,
            'posts' => $posts,
            'users' => $users,
            'tab' => $tab,
            'followings_count' => $user->followings()->count(),
            'followers_count' => $user->followers()->count(),
        ]);
    }

    //user退会
    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete(); // ユーザー削除
        auth()->logout(); //ログアウト処理        
        //$request->session()->invalidate();// 4. セッションの無効化と再生成
        //$request->session()->regenerateToken();
        return redirect('/')->with('success', '退会手続きが完了しました。');
    }

    //ユーザ編集
    public function edit($id) 
    {
        $user = User::findOrFail($id);
        return view('user.edit',['user' =>$user]);
    }

    //ユーザ更新
    public function update(UserRequest $request, $id) 
    {
        if (!empty($request->id)) 
        {
            $user = User::find($request->id);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('welcome');
    }

}