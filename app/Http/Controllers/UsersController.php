<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    

    public function show($id)
    {
        $user = User::findOrFail($id);
        $post = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'posts' => $post,
        ];
        return view('users.show',$data);
    }
}