<?php

namespace App\Http\Controllers;

use App\Post;
use App\Reaction;
use App\Http\Requests\ReactionRequest;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReactionReceived;

class ReactionsController extends Controller
{
    public function store(ReactionRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $reaction = Reaction::where('post_id', $post->id)
            ->where('user_id', Auth::id())
            ->first();

        Reaction::updateOrCreate(
            [
                'post_id' => $post->id,
                'user_id' => Auth::id(),
            ],
            [
                'reaction_type' => $request->reaction_type,
                'encouragement' => optional($reaction)->encouragement,
            ]
        );

        if (! $reaction && $post->user_id !== Auth::id()) {
            $post->user->notify(
                new ReactionReceived($post, Auth::user(), $request->reaction_type)
            );
        }

        return back()
            ->withInput($request->only('encouragement'))
            ->with('status', 'リアクションが更新されました。ありがとう！');
    }

    public function encourage(ReactionRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $reaction = $post->reactions()
            ->where('user_id', Auth::id())
            ->first();

        if (! $reaction) {
            return back()->withErrors([
                'encouragement' => '先にリアクションを選んでね！',
            ])->withInput();
        }

        if (! $request->filled('encouragement')) {
            return back()->withErrors([
                'encouragement' => 'ひとことハゲマシを入力してね！',
            ])->withInput();
        }

        $reaction->encouragement = $request->encouragement;
        $reaction->save();

        return back()->with('status', 'ひとことハゲマシが送られました。ありがとう！');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $reaction = $post->reactions()
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $reaction->delete();

        return back()->with('status', 'リアクションを取り消しました。');
    }
}
