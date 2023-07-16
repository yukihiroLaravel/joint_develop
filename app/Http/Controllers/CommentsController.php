<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request)
   {
       $comment = new Comment();
       $comment->comment = $request->input('comment.' . $request->post_id);
       $comment->post_id = $request->post_id;
       $comment->user_id = Auth::user()->id;
       $comment->save();

       return redirect('/')->with([
        'flash_msg' => 'コメントを投稿しました',
        'cls' => 'success'
    ]);
   }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (\Auth::id() === $comment->user_id) {
            $comment->delete();
        }
        return redirect('/')->with([
            'flash_msg' => 'コメントを削除しました',
            'cls' => 'success'
        ]);
    }
}
