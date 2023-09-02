<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{
    public function index()
    {
        // $posts = Post::orderBy('id','desc')->paginate(9);
        
        $users = User::all();
        $posts = Post::where("user_id", $users->id);
        
        return view("welcome",["posts" => $posts , "users" => $users]);
    }
}
