<?php

namespace App\Http\Controllers;

use App\Reaction;
use Illuminate\Http\Request;

class ReactionsController extends Controller
{
    // すでにリアクションがあればリアクションを削除、なければ追加するメソッド
    public function toggle(Request $request, $postId)
    {
        // ログインしていなければ何もしない
        if (!\Auth::check()) {
            return back();
        }

        $post = \App\Post::findOrFail($postId);

        $request->validate([
            'type' => 'nullable|in:heart', // 現在は、空か'heart'のみ
        ]);
        $type = $request->input('type', 'heart'); // 現在は'heart'をデフォルトとする

        // ログインしているユーザーが押したリアクション かつ、今回リアクションしようとしている投稿、
        // かつ 同じtypeの投稿を取得
        // 1件もなければnull
        $reaction = Reaction::where('user_id', \Auth::id())
            ->where('post_id', $postId)
            ->where('type', $type)
            ->first();

        if ($reaction) {
            $reaction->delete();
        } else {
            $reaction = new Reaction();
            $reaction->user_id = \Auth::id();
            $reaction->post_id = $postId;
            $reaction->type = $type;
            $reaction->save();
        }

        return back();
    }
}
