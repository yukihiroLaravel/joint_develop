<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class UsersController extends Controller
{

    public function show($id)
    {
        $user = User::findOrFail($id);
        $data=[
            'user' => $user,
        ];
        return view('users.show', $data);
    }

}
