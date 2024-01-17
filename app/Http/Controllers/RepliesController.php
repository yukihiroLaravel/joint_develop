<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        // ログインしていなかったらログインページに遷移する（この処理を消すとログインしなくてもページを表示する）
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reply_content' => 'required|max:140',
        ]);

        $reply = new Reply();
        $reply->reply = $request->input('reply_content');
        $reply->article_id = $request->input('article_id');
        $reply->user_id = Auth::user()->id;
        $reply->save();

        return redirect('/');
    }

    public function show($id)
    {
        $post = Post::with('replies')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    //     if ($reply) {
    //         $reply->delete();
    //         // 削除後の処理（リダイレクトなど）
    //     } else {
    //         // エラーメッセージを表示する処理
    //         return redirect()->back();
    //     }
    // }
}

