<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UsersController extends Controller
{
    use AuthenticatesUsers;
    
    public function index()
    {
        return view('welcome');
    }

    public function edit($id)
    {   
        $user = \Auth::user();
        $user = User::findOrFail($id);
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    protected function store(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
        }
        return back();
    }
}
