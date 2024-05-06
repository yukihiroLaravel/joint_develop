<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    // ユーザ詳細
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user', $user));
    }
}
