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

    public function destroy($postId, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        if (\Auth::id() === $comment->user_id && $comment->post_id == $postId) {
            $comment->delete();
            return back()->with('withdraw_message', '削除しました！');
        }
    }

}
