<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\User;
use App\Comment;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $comments = Comment::where('post_id', $id)->orderBy('id', 'desc')->paginate(10);
        $data = [
            'post' => $post,
            'comments' => $comments,
        ];
        return view('comments.comments', $data);
    }

    public function store(CommentRequest $request)
    {
        $comment = new Comment;
        $comment->user_id = $request->user()->id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->input('comment.' . $request->post_id) ?? '';
        $comment->save();
        $img = $request->file('img_path');
        if ($img) {
            $path = $img->storeAs('public/comment.img', $comment->id . '.' . time() . '.' . $request->img_path->extension());
            $comment->img_path = $path;
            $comment->save();
        }
        return back()->with('greenMessage', 'コメントしました');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if (\Auth::id() === $comment->user_id) {
            $comment->delete();
        }
        return back()->with('redMessage', 'コメント削除しました');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $comment = Comment::findOrFail($id);
        $data=[
            'user' => $user,
            'comment' => $comment,
        ];
        if ($comment->user_id === \Auth::id()) {
            return view('comments.edit', $data);
        }
        abort(404);
    }

    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->comment = $request->input('comment.' . $request->post_id) ?? '';
        $img = $request->file('img_path');
        if ($img) {
            $path = $img->storeAs('public/comment.img', $comment->id . '.' . time() . '.' . $request->img_path->extension());
            $comment->img_path = $path;
            $comment->save();
        }
        $comment->save();
        return redirect('/')->with('greenMessage', '更新しました');
    }
}
