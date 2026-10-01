<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        //今後実装予定
        //$posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            //'posts' => $posts,
        ];

        return view('users.show', $data);
    }
}