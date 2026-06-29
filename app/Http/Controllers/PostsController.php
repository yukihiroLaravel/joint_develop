<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Post;
=======
use Illuminate\Http\Request;
>>>>>>> 301d37908ca4d4a9e480f54ec8d89cfddb98938b

class PostsController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
}
=======
        return view('welcome');
    }
}
>>>>>>> 301d37908ca4d4a9e480f54ec8d89cfddb98938b
