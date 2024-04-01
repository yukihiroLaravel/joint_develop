<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:140'], // 必須のコメント本文
            'post_id' => ['required', 'exists:posts,id'], // 存在する投稿IDであることを確認
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = Auth::id();
        $comment->post_id = $request->post_id;
        $comment->save();

        return back()->with('comment_register_message', 'コメントしました');
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