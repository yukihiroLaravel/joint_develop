<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * トップページを表示。
 * @param void
 * @return view
 */
class PostController extends Controller
{
    public function showTop () {
        return view('posts.top');
    }
}
