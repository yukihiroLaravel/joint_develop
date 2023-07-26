<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\user;

use Illuminate\Http\Request;

/**
 * トップページを表示。
 * @param void
 * @return view
 */
class PostController extends Controller
{
    public function showTop () {
        $posts = DB::table('posts')->paginate(10);

        return view('posts.top', ['posts' => $posts]);
    }
}
