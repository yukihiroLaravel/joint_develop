<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    //ユーザ削除
    public function destroy($id)
    {
    // 指定されたIDのユーザーを取得
    $user = User::findOrFail($id);

    if (!$user) {
        // ユーザーが存在しない場合の処理（エラーハンドリングなど）アレンジ用
        // 例えば、リダイレクトしてエラーメッセージを表示するなど　アレンジ用
    }
    $user->delete();// ユーザーを削除
    return redirect()->route('top'); // 一覧画面へのルート名を適宜変更 // 削除したらリダイレクト
    }
 }
       