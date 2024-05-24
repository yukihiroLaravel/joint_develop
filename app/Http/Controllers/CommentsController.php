<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Post;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(CommentRequest $request)
    {
        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->post_id = $request->post_id;
        $comment->user_id = \Auth::id();
        $comment->save();
        session()->flash('flash_message', 'コメント登録しました！');
        return redirect('/');
    }

    public function update(Request $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $comment->comment = $request->comment_content;
        $comment->save();
        return response()->json(['success' => true, 'message' => 'Comment updated']);
    }

    public function destroy(Request $request, $comment_id)
    {
        $comment = Comment::find($comment_id);
        if ($comment) {
            $comment->delete();
            return response()->json(['success' => true, 'message' => 'Comment deleted']);
        } else {
            return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
        }
    }
}
