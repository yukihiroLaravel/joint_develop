<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Post;

class PostsController extends Controller
{
    public function store(PostRequest $request) {
        $posts = new Post;
        $posts->content = $request->content;
        $posts->user_id = $request->user()->id;
        $posts->save();
        return back();
    }
}
