<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\User;
use App\Comment;
use App\Http\Requests\CommentRequest;
use COM;

class CommentsController extends Controller
{

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::where('post_id', $id)->orderBy('id', 'desc')->paginate(10);
        $data = [
            'post' => $post,
            'comments' => $comments,
        ];
        return view('comments.comments', $data);
    }

    public function store(CommentRequest $request)
    {
        $comment = new Comment;
        $comment->comment = $request->input('comment.' . $request->post_id);
        $comment->post_id = $request->post_id;
        $comment->user_id = $request->user()->id;
        $comment->save();
        return back()->with('greenMessage', 'コメントしました');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (\Auth::id() === $comment->user_id) {
            $comment->delete();
        }
        return back()->with('redMessage', 'コメント削除しました');
    }

}
