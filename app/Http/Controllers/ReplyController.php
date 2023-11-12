<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Post;
use App\Reply;
use App\User;

class ReplyController extends Controller
{
    // リプライ投稿画面遷移
    public function create($postId)
    {
        $post = Post::findOrFail($postId);
        return view('replies.create', compact('post'));
    }
    // リプライ投稿
    public function store($postId, ReplyRequest $request)
    {
        $reply = new Reply();
        $reply->content = $request->input('content');
        $reply->user_id = $request->user()->id;
        $post = Post::findOrFail($postId);
        $post->replies()->save($reply);
        return redirect()->route('replies.index', $postId)->with('status', 'リプライしました');
    }
    // リプライ編集画面遷移
    public function edit($postId, $replyId)
    {
        $post = Post::findOrFail($postId);
        $reply = Reply::findOrFail($replyId);
        if (\Auth::id() === $reply->user_id) {
            return view('replies.edit', compact('post', 'reply', 'postId', 'replyId'));
        } else {
            return redirect('/');
        }
    }
    // リプライ更新
    public function update($postId, $replyId, ReplyRequest $request)
    {
        $post = Post::findOrFail($postId);
        $reply = Reply::findOrFail($replyId);
        if (\Auth::id() === $reply->user_id) {
            $reply->content = $request->input('content');
            $reply->save();
            // リプライ更新後にリプライ一覧表示へ遷移
            return redirect()->route('replies.index', $postId);
        } else {
            return redirect('/');
        }
    }
    // リプライ削除
    public function destroy($postId, $replyId)
    {
        $post = Post::findOrFail($postId);
        $reply = Reply::findOrFail($replyId);
        if (\Auth::id() === $reply->user_id) {
            $reply->delete();
        }
        // リプライ削除後にリプライ一覧表示へ遷移
        return redirect()->route('replies.index', $postId)->with('status', 'リプライを削除しました');
    }
    // リプライ表示
    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        $replies =  $post->replies()->orderBy('id', 'desc')->paginate(10);
        return view('replies.index', compact('post', 'replies'));
    }
}