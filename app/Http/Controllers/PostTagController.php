<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function destroy(Post $post, Tag $tag)
    {
        // 投稿者本人以外は不可
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }

        $post->tags()->detach($tag->id);

        return back();
    }
}
