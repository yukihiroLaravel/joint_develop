<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\User;
use App\Comment;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{

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
        $comment = Comment::find($id);
        if (\Auth::id() === $comment->user_id) {
            $comment->delete();
        }
        return back();
    }

}
