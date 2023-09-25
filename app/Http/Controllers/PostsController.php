<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(1);
        return view('welcome', [
            'users' => $users,
        ]);
    }
}
