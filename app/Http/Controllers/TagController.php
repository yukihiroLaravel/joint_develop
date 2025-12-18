<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts()->with('tags')->orderBy('id', 'desc')->paginate(10);

        return view('tags.show', compact('tag', 'posts'));
    }
}
