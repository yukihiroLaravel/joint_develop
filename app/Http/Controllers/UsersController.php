<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\post;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
    
        return view('users.show', $data);
    }
}
