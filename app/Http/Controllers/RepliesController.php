<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Reply;
use App\Post;

class RepliesController extends Controller
{
    public function store(Request $request, $postId)
    {
        // バリデーション
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // 返信を作成
        $reply = new Reply();
        $reply->content = $request->content;
        $reply->user_id = Auth::id();
        $reply->post_id = $postId;
        $reply->save();

        return back()->with('success', '返信を投稿しました！');
    }

    public function destroy($id)
    {
        // 返信を取得
        $reply = Reply::findOrFail($id);

        // 返信が現在のユーザによって作成されたか確認
        if ($reply->user_id !== Auth::id()) {
            return back()->with('error', 'この返信を削除する権限がありません。');
        }

        // 返信を削除
        $reply->delete();

        return back()->with('success', '返信を削除しました。');
    }
}
