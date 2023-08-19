<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function new()
    {
        return view('comments.comment');
    }
    
    public function store(CommentRequest $request)
    {
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->user_id = $request->user()->id;
        $comment->post_id = $request->post_id;
        $comment->save();
        return back()->with('messageSuccess', 'コメントしました');
    }
}
