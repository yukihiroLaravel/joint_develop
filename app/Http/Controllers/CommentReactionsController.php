<?php

namespace App\Http\Controllers;

use App\CommentReaction;
use App\Comment;
use App\Post;
use App\Http\Requests\ReactionRequest;

class CommentReactionsController extends Controller
{
    // すでにリアクションがあればリアクションを削除、なければ追加する
    public function toggle(ReactionRequest $request, $postId, $commentId)
    {
        $post = Post::findOrFail($postId);
        $comment = Comment::findOrFail($commentId);

        // コメントがこの投稿のものか確認
        if ($comment->post_id !== $post->id) {
            abort(404, 'コメントが存在しません。');
        }

        $type = $request->input('type', 'heart'); // 現在は'heart'をデフォルトとする

        // ログインしているユーザーが押したリアクション かつ、今回リアクションしようとしているコメント、
        // かつ 同じtypeのリアクションを取得
        // 1件もなければnull
        $reaction = CommentReaction::where('user_id', \Auth::id())
            ->where('comment_id', $comment->id)
            ->where('type', $type)
            ->first();

        if ($reaction) {
            $reaction->delete();
        } else {
            $reaction = new CommentReaction();
            $reaction->user_id = \Auth::id();
            $reaction->comment_id = $comment->id;
            $reaction->type = $type;
            $reaction->save();
        }

        return back();
    }
}
