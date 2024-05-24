<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // Userモデルを使用

class FollowController extends Controller
{
    // ユーザーをフォローするアクション
    public function store($id)
    {
        // 指定されたIDのユーザーが存在するか確認し、存在しなければ404エラーを返す
        $userToFollow = User::findOrFail($id);
    
        // 認証されたユーザーが対象のユーザーをフォローしようと試み、結果を取得
        $result = auth()->user()->follow($id);
    
        // フォローの結果に基づいて適切なリダイレクト応答を返す
        if ($result) {
            // フォロー成功時は成功メッセージをセッションに追加
            return redirect()->back()->with('success', 'User followed!');
        } else {
            // フォロー失敗時（既にフォローしている場合など）はエラーメッセージをセッションに追加
            return redirect()->back()->with('error', 'Cannot follow this user.');
        }
    }
    
    // ユーザーのフォローを解除するアクション
    public function destroy($id)
    {
        // アンフォロー実行と結果の取得
        $result = auth()->user()->unfollow($id);
        // ページをリダイレクト
        return back();
    }
}