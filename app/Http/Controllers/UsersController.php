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
        $contents = $user->contents()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'contents' => $contents,
        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }


}
