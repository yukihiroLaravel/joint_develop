<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'reply' => 'required|max:140',
    ]);

    Reply::create([
        'post_id' => $postId,
        'user_id' => Auth::id(),
        'reply' => $request->reply,
    ]);

    return redirect()->back()->with('success', '返信を投稿しました');
    }
}
