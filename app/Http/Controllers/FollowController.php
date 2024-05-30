<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // Userモデルを使用

class FollowController extends Controller
{
    // ユーザをフォローするアクション
    public function store($id)
    {
        // 指定されたIDのユーザが存在するか確認し、存在しなければ404エラーを返す
        $userToFollow = User::findOrFail($id);

        // 認証されたユーザが対象のユーザをフォローしようと試み、結果を取得
        $result = auth()->user()->follow($id);

        // フォローの結果に基づいて適切なリダイレクト応答を返す
        if ($result) {
            // フォロー成功時は成功メッセージをセッションに追加
            return redirect()->back()->with('success', $userToFollow->name . 'さんをフォローしました');
        } else {
            // フォロー失敗時（既にフォローしている場合など）はエラーメッセージをセッションに追加
            return redirect()->back()->with('error', 'フォロー処理に失敗しました');
        }
    }

    // ユーザのフォローを解除するアクション
    public function destroy($id)
    {
        // 指定されたIDのユーザが存在するか確認し、存在しなければ404エラーを返す
        $userToFollow = User::findOrFail($id);

        // アンフォロー実行と結果の取得
        $result = auth()->user()->unfollow($id);

        if ($result) {
            // フォロー解除成功時
            return back()->with('success', $userToFollow->name . 'さんのフォローを解除しました');
        } else {
            // フォロー解除失敗時
            return back()->with('error', 'フォロー解除処理に失敗しました');
        }
    }
}
