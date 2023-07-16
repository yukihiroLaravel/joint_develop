<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function showTop () {
        return view('Topicposts.top');
    }
}
