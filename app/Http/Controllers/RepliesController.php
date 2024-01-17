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

    public function store(Request $request, $article_id)
    {
        $request->validate([
            'reply_content' => 'required|max:140',
        ]);

        $reply = new Reply();
        $reply->reply = $request->input('reply_content');
        $reply->article_id = $article_id; // ルートパラメータから取得
        $reply->user_id = Auth::user()->id;
        $reply->save();

        return redirect('/');
    }

    public function show($id)
    {
        $post = Post::with('replies')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    // 返信削除
    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);
        if (\Auth::id() === $reply->user_id){
            $reply->delete();
        }
        return back()->with('message', '返信を削除しました！');
    }
}

