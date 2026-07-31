<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReactionReplyRequest;
use App\Reaction;
use App\ReactionReply;
use Illuminate\Support\Facades\Auth;

class ReactionRepliesController extends Controller
{
    public function store(ReactionReplyRequest $request, $id, $reactionId)
    {
        $reaction = Reaction::findOrFail($reactionId);

        $reply = ReactionReply::create([
            'reaction_id' => $reaction->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);



        return redirect('/posts/' . $id);
    }

    public function destroy($id, $reactionId, $replyId)
    {
        $reply = ReactionReply::findOrFail($replyId);

        // 投稿者本人だけ削除できる
        if (Auth::id() !== $reply->user_id) {
            abort(403);
        }

        $reply->delete();

        return redirect()->back();
    }

    public function update(ReactionReplyRequest $request, $id, $reactionId, $replyId)
    {
        $reply = ReactionReply::findOrFail($replyId);

        //  本人だけ更新可能
        if (Auth::id() !== $reply->user_id)
            {
                abort(403);
            }

            $reply->update([
                'content' => $request->content,
            ]);

                return redirect()->back();
    }
}
