<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

use function PHPUnit\Framework\returnValueMap;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $post = Post::findOrFail($id);

        $comments = $post->comments;
        return view('comments.index', [
            'comments' => $comments,
            'post' => $post,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $post = Post::findOrFail($id);

        $comments = $post->comments;
        return view('comments.create', [
            'comments' => $comments,
            'post' => $post,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);
        // //withメソッドを使用してコメント投稿フラッシュメッセージを記述
        return redirect()->route('post.show', $request->post_id)->with('greenMessage', 'コメントを投稿しました');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return back()->withErrors('権限がありません');
        }

        return view('comments.edit', [
            'comment' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id()) {
            return back()->withErrors('権限がありません');
        }

        $comment->update([
            'content' => $request->input('content'),
        ]);
        //withメソッドを使用して投稿編集フラッシュメッセージを記述
        return redirect()->route('post.show', $comment->post_id)->with('greenMessage', 'コメントを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        //コメントの所有者であるかを確認
        if ($comment->user_id !== auth()->id()) {
            //所有者でない場合、エラーメッセージを表示し元のページにリダイレクト
            return back()->withErrors('権限がありません');
        }

        $comment->delete();
        //withメソッドを使用してフラッシュメッセージを記述
        return redirect()->route('post.show', $comment->post_id)->with('redMessage', 'コメントを削除しました');
    }
}
