<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
   {
        $comments = Comment::orderBy('created_at', 'desc')->paginate(10);
        return view('comments.index', [
            'comments' => $comments,
        ]);
   
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:140'], // 必須のコメント本文
        ]);

        $user = \Auth::user();
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = $user->id;
        $comment->post_id = $post->id;
        $comment->save();

        return back();
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post->comments()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'post' => $post,
            'comments' => $comments,
        ];
        
        return view('comments.show', $data);
    }
}