<?php

namespace App\Http\Controllers;

use App\Reaction;
use App\Http\Requests\ReactionRequest;

class ReactionsController extends Controller
{
    // すでにリアクションがあればリアクションを削除、なければ追加するメソッド
    public function toggle(ReactionRequest $request, $postId)
    {
        // ログインしていなければ何もしない
        if (!\Auth::check()) {
            return back();
        }

        $post = \App\Post::findOrFail($postId);

        $type = $request->input('type', 'heart'); // 現在は'heart'をデフォルトとする

        // ログインしているユーザーが押したリアクション かつ、今回リアクションしようとしている投稿、
        // かつ 同じtypeの投稿を取得
        // 1件もなければnull
        $reaction = Reaction::where('user_id', \Auth::id())
            ->where('post_id', $post->id)
            ->where('type', $type)
            ->first();

        if ($reaction) {
            $reaction->delete();
        } else {
            $reaction = new Reaction();
            $reaction->user_id = \Auth::id();
            $reaction->post_id = $post->id;
            $reaction->type = $type;
            $reaction->save();
        }

        return back();
    }
}
