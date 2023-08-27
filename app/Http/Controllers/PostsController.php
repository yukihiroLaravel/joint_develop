<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts->orderBy('id', 'desc')->paginate(10);
        $data=[
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }
    
    public function index()
    {
        return view('welcome');
    }
}
