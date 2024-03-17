<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index()
   {
        $comments = Comment::orderBy('created_at', 'desc')->paginate(10);
        return view('comments.index', [
            'comments' => $comments,
        ]);
   
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:140'], // 必須のコメント本文
            'post_id' => ['required', 'exists:posts,id'], // 存在する投稿IDであることを確認
        ]);

        $user = \Auth::user();
        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = $user->id;
        $comment->post_id = $request->post_id;
        $comment->save();

        return back();
    }

    public function show($id)
    {
        $user = \Auth::user();
        $post = Post::findOrFail($id);
        $posts = Post::all();
        $comments = $post->comments()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'post' => $post,
            'posts' => $posts,
            'comments' => $comments,
        ];
        
        return view('comments.show', $data);
    }
}