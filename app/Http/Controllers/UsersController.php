<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Posts;


class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts->get();
        $data=[
            'user' => $user,
            'posts' => $posts
        ];
   
        return view('users.show',$data);
    }
}