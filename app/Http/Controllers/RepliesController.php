<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function store(Request $request, $post_id)
    {
        $request->validate([
            'reply_content' => 'required|max:140',      //返信は140文字以内
            'post_id' => 'required|exists:posts,id',    //post_idがpostテーブルに存在するかを確認
        ]);

        $reply = new Reply();
        $reply->content = $request->input('reply_content');
        $reply->post_id = $post_id; // ルートパラメータから取得
        $reply->user_id = Auth::user()->id;
        $reply->save();

        return redirect('/');
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

