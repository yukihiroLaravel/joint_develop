<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    // いいね！する
    public function store($id)
    {
        // 存在しない(論理削除済含む)投稿は404エラー
        $post = Post::findOrFail($id);

        // 自分の投稿にはいいね!が出来ない
        if ($post->user_id == Auth::id()) {
            abort(403);
        }

        // すでにいいね!済みなら何もしない(重複登録しない)
        $post->likedUsers()->syncWithoutDetaching([Auth::id()]);

        return response()->json([
            'liked' => true,
            'count' => $post->likedUsers()->count(),
        ]);
    }

    // いいね!を解除する
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // 自分のいいね!だけを削除(未いいね!なら何もしない)
        $post->likedUsers()->detach(Auth::id());

        return response()->json([
            'liked' => false,
            'count' => $post->likedUsers()->count(),
        ]);
    }
}
