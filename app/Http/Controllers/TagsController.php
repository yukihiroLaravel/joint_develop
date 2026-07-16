<?php

namespace App\Http\Controllers;

use App\Reaction;
use App\Tag;

class TagsController extends Controller
{
    // 指定したタグが付いている投稿一覧を表示
    public function show($id)
    {
        $tag = Tag::findOrFail($id);

        $posts = $tag->posts()
            ->with(['user', 'reactions', 'tags'])
            ->orderBy('posts.id', 'desc')
            ->paginate(10);

        $reactionTypes = Reaction::TYPES;

        return view('tags.show', [
            'tag' => $tag,
            'posts' => $posts,
            'reactionTypes' => $reactionTypes,
        ]);
    }
}
