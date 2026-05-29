<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', [
            'user' => $user,
        ]);
    }

    // ユーザ退会
    public function destroy($id)
    {
        $user = \Auth::user();
        if ($id === $user->id) {
            $user->delete();
        }
        return redirect('/');
    }
}
