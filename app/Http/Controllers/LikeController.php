<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;  // Postモデルのインポートを追加

class LikeController extends Controller
{
    public function store(Post $post)
    {
        if (!$post->likedByUsers->contains(auth()->id())) {
            $post->likedByUsers()->attach(auth()->id());
        } else {
            $post->likedByUsers()->detach(auth()->id());
        }

        return back();
    }
}
