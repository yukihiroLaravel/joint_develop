<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        // return view('welcome', compact('users'));
        return view('welcome', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts();
        $data = [
            'user'=> $user,
            'posts'=>$posts
        ];
        return view('users.show', $data);
    }

}
