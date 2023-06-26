<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function show($id)
    {
        $posts = Post::findOrFail($id);
        $comments = $posts->comments()->orderByDesc('created_at')->paginate(10);
        $data = [
            'posts' => $posts,
            'comments' => $comments,
        ];
        return view('posts.comment', $data);
    }

    public function store(CommentRequest $request,$id)
    {
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->user_id = \Auth::id();
        $comment->post_id = $id;
        $comment->save();
        return back();
    }

    //コメント削除
    public function destroy($postId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (\Auth::id() === $comment->user_id && $comment->post_id == $postId) {
            $comment->delete();
            return back()->with('withdraw_message', '削除しました！');
        }
    }

    //コメント編集
    public function edit($postId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (\Auth::id() === $comment->user_id && $comment->post_id == $postId) {
            $posts = Post::findOrFail($postId);
            return view('posts.comment_edit', [
                'comment' => $comment,
                'posts' => $posts,
            ]);
        }
    }

    //コメント更新
    public function update(CommentRequest $request, $postId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (\Auth::id() === $comment->user_id && $comment->post_id == $postId) {
            $comment->body = $request->body;
            $comment->save();
        }
        return redirect()->route('comment.show', $postId)->with('withdraw_message', '回答を更新しました！');;
    }

}
