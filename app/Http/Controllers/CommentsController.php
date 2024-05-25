<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Post;
use App\User;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index()
    {
        $user = Auth::user();//ユーザー情報を取得
        $posts = Post::paginate(10);//投稿を取得
        $comments = Comment::get();//コメントを取得
        
        return view('comments.index', compact('user', 'posts', 'comments'));
    }

    public function create()
    {
        $user =\Auth::user();
        $comments = $user->comments()->orderBy('id', 'desc')->paginate(9);
        $data = [
            'user' => $user,
            'comments'=> $comments,
        ];

        return view('comments.create', $data);
    }


    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        //指定したコメントを1件のみ取得
        $comment = Comment::where('id', '=', $id)->first();
        //存在しないIDが指定された場合リダイレクトする
        if(!$comment) {
            return redirect('/comments');
        }
        return view('comments.show')->with('comment', $comment);
    }

    public function store(CommentRequest $request)
    {
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = $request->user()->id;
        $comment->save();
        return back();
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if(\Auth::id() === $comment->user_id) {
            $comment->delete();
        }    
        return back();
    }
}
