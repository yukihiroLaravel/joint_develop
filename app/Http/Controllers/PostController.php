<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\user;
use App\Post;

use Illuminate\Http\Request;

/**
 * トップページを表示。
 * @param void
 * @return view
 */
class PostController extends Controller
{
    public function showTop () {
        $posts = Post::orderBy('created_at','desc')->paginate(10);

        return view('posts.top', ['posts' => $posts]);
    }
}
