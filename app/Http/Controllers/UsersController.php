<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // 追記

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

}