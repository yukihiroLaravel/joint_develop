<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;

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
    public function store(PostRequest $request)
    {
        $user = Auth::user();
        $comment = new Comment;
        $comment->user_id = $user->id;
        $comment->content = $request->content;
        $comment->save();

        return back();
    }
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        if (\Auth::id() === $comment->user_id) {
            return view('comment.comment',[
                'comment' => $comment,
            ]);
        }
        return back();
    }

}
