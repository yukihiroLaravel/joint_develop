<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Http\Requests\CommentsRequest;

class CommentsController extends Controller
{
    // コメント投稿
    public function store(CommentsRequest $request, $postId)
    {
        $post = Post::findOrFail($postId);

        // コメント返信の場合、親コメントが存在するか確認
        if ($request->parent_id !== null) {
            $parentComment = Comment::findOrFail($request->parent_id);
            if ($parentComment->post_id !== $post->id) {
                abort(404, '親コメントが存在しません。');
            }
        }

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->parent_id = $request->parent_id;
        $comment->post_id = $post->id;
        $comment->user_id = \Auth::id();
        $comment->save();

        return back()->with('success', 'コメントを投稿しました！');
    }

    // コメント更新
    public function update(CommentsRequest $request, $postId, $commentId)
    {
        $post = Post::findOrFail($postId);
        $comment = Comment::findOrFail($commentId);

        // コメントがこの投稿のものか確認
        if ($comment->post_id !== $post->id) {
            abort(404, 'コメントが存在しません。');
        }
        // コメントの投稿者か確認
        if ($comment->user_id !== \Auth::id()) {
            abort(403, '更新権限がありません。');
        }
        // コメントを更新
        $comment->content = $request->content;
        $comment->save();

        return back()->with('success', 'コメントを更新しました！');
    }

    // コメント削除
    public function destroy($postId, $commentId)
    {
        $post = Post::findOrFail($postId);
        $comment = Comment::findOrFail($commentId);

        // コメントがこの投稿のものか確認
        if ($comment->post_id !== $post->id) {
            abort(404, 'コメントが存在しません。');
        }
        // コメントの投稿者か確認
        if ($comment->user_id !== \Auth::id()) {
            abort(403, '削除権限がありません。');
        }
        // コメントを削除
        $comment->delete();
        return back()->with('success', 'コメントを削除しました！');
    }
}
