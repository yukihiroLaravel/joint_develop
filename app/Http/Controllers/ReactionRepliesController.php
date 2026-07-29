<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reaction;
use App\ReactionReply;
use Illuminate\Support\Facades\Auth;

class ReactionRepliesController extends Controller
{
    public function store(Request $request, $reactionId)
    {
        $request->validate([
            'content' => 'required|string|max:100',
        ]);

        $reaction = Reaction::findOrFail($reactionId);

        ReactionReply::create([
            'reaction_id' => $reaction->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back();
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

    public function update(Request $request, $id, $reactionId, $replyId)
    {

        $request->validate([
            'content' => 'required|string|max:100',
        ]);

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
