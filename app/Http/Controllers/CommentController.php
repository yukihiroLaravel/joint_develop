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
        return view('comments.comments', $data);
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

    private function isCommentOwner($postId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $post = Post::findOrFail($postId);

        if (\Auth::id() === $comment->user_id && $comment->post_id === $post->id) {
            return true;
        } else {
            return false;
        }
    }

    //コメント削除
    public function destroy($postId, $commentId)
    {
        if ($this->isCommentOwner($postId, $commentId)) {
            $comment = Comment::findOrFail($commentId);
            $comment->delete();
            return back()->with('withdraw_message', '削除しました！');
        } else {
            return view('errors.404');
        }
    }

    //コメント編集
    public function edit($postId, $commentId)
    {
        if ($this->isCommentOwner($postId, $commentId)) {
            $comment = Comment::findOrFail($commentId);
            $post = Post::findOrFail($postId);

            return view('comments.comment_edit', [
                'comment' => $comment,
                'post' => $post,
            ]);
        } else {
            return view('errors.404');
        }
    }

    //コメント更新
    public function update(CommentRequest $request, $postId, $commentId)
    {
        if ($this->isCommentOwner($postId, $commentId)) {
            $comment = Comment::findOrFail($commentId);
            $comment->body = $request->body;
            $comment->save();

            return redirect()->route('comment.show', $postId)->with('withdraw_message', '回答を更新しました！');
        } else {
            return view('errors.404');
        }
    }

}
