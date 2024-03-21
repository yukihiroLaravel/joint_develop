<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Comment;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    public function create()
    {
        $user = \Auth::user();
        $comments = $user->comments()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'comments' => $comments,
        ];
        return view('comments.create', $data);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (\Auth::id() === $comment->user_id){
            $comment->delete();
        }
        return back();
    }

}
