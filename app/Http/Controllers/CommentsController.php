<?php

namespace App\Http\Controllers;

use App\Comment;
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
    public function index(Post $post)
    {
        $comments = $post->comments;
        return view('comments.index', compact('comments', 'post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        $comments = $post->comments;
        return view('comments.create', compact('comments', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //この書き方以外もあるっぽいので調べる　ヒントはpostcontroller update(PostRequest $request, $id)
        $request->validate([
            'content' => 'required|max:140',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'content' => $request->content,
        ]);
        // //withメソッドを使用してコメント投稿フラッシュメッセージを記述
        return redirect()->route('post.show', $request->post_id)->with('greenMessage', 'コメントを投稿しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($comment_id)
    {
        //   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return back()->withErrors('権限がありません');
        }

        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return back()->withErrors('権限がありません');
        }

        $request->validate([
            'content' => 'required|max:140',
        ]);

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
    public function destroy(Request $request, Comment $comment)
    {
        // dd($comment);
        // dd($comment->user_id !== auth()->id());

        //コメントの所有者であるかを確認
        if ($comment->user_id !== auth()->id()) {
            //所有者でない場合、エラーメッセージを表示し元のページにリダイレクト
            return back();
        }

        $comment->delete();
        //withメソッドを使用してコメント削除フラッシュメッセージを記述
        return redirect()->route('post.show', $comment->post_id)->with('redMessage', 'コメントを削除しました');
    }
}
