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
        $postId = $request->post_id;
        $commentContent = $request->input('comment_' . $postId);
        $comment = new Comment;
        $comment->comment = $commentContent;
        $comment->post_id = $postId;
        $comment->user_id = \Auth::id();
        $comment->save();
        session()->flash('flash_message', 'コメント登録しました！');
        return redirect()->back()->withInput([]);
    }

    public function update(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->comment = $request->comment_content;
        $comment->save();
        return response()->json(['success' => true, 'message' => 'Comment updated']);
    }

    public function destroy(Request $request, $commentId)
    {
        $comment = Comment::find($commentId);
        if ($comment) {
            $comment->delete();
            return response()->json(['success' => true, 'message' => 'Comment deleted']);
        }
        return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
    }
}
