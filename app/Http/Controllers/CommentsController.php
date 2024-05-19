<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        // バリデーションルールの定義
        $rules = [
            'comment' => 'required', // コメントが必須であることを指定
        ];

        // バリデーションの実行
        $validator = Validator::make($request->all(), $rules);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Commentモデル作成
        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = \Auth::id();
        $comment->save();
        session()->flash('flash_message', 'コメント登録しました！');
        return redirect('/');

        // コメントの保存が成功したことを示すレスポンスを返す
        return response()->json([
            'success' => true,
            'comment' => $comment,
        ]);
    }

    public function update(Request $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $comment->comment = $request->comment_content;
        $comment->save();
        // コメントの更新後にJSONレスポンスを返す
        return response()->json(['success' => true, 'message' => 'Comment updated']);
    }

    public function destroy(Request $request, $comment_id)
    {
        $comment = Comment::find($comment_id);
        if ($comment) {
            $comment->delete();
            // コメントの削除後にJSONレスポンスを返す
            return response()->json(['success' => true, 'message' => 'Comment deleted']);
        } else {
            return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
        }
    }
}
