<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $movies = $user->movies()->orderBy('id','desc')->paginate(9);
        $deta=[

            'user' => $user,
            'movies' =>$movies,

        ];
        $data += $this->userCounts($user);
        return view('users.show',$data);
    }
}
