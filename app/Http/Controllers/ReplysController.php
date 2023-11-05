<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Post;
use App\Http\Requests\ReplyRequest;

class ReplysController extends Controller
{
    public function store(ReplyRequest $request,$id)
    {
        $reply = new Reply;
        $reply->reply = $request->reply;

        $post = Post::find($id);
        if ($post) {
            $reply->post()->associate($post); 
        }
        $reply->save();
        return back();
    }
}
