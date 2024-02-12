<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(10);
        // 変数は配列の形で持っていく
        return view('welcome', [
            'users' => $users,
        ]);
        
        $posts = Post::latest()->get();
        return view('welcome', compact('posts'));
    }
}
