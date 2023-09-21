<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $tweets = $user->tweets()->orderBy('id', 'desc');

        $data = [
            'user' => $user,
            'tweets' => $tweets,
        ];
    
        $data += $this->userCounts($user);
    
        return view('users.show', $data);
    }
}
