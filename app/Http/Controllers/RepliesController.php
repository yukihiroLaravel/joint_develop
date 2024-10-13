<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;
use App\User;
use App\Post;
Use App\Reply;


class RepliesController extends Controller
{
    public function store(ReplyRequest $request)
    {
        $reply = new Reply();
        $reply->comment = $request->comment;
        $reply->post_id = $request->postId;
        $reply->user_id = \Auth::user()->id;
        $reply->save();

        $this->showFlashSuccess("返信しました。");
        return back();
    }
 
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $reply = $post->replies()->orderBy('id', 'desc');
        $data=[
            'post' => $post,
            'replies' => $reply,
        ];
        $data += $this->replyCounts($post);
        return view('posts.replies',$data);
    }

    public function destroy(Reply $reply)
    {
        if (\Auth::id() === $reply->user_id) {
            $reply->delete();
        }
        $this->showFlashSuccess("削除しました。");
        return back();
    }
}