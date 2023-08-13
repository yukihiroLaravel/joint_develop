<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user = $user->orderBy('id', 'desc');
        $data=[
            'user' => $user,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }
    
    public function index()
    {
        return view('welcome');
    }
}
