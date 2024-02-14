<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function edit($id) {
        $user = \Auth::user();

        if (\Auth::check() && \Auth::id() == $id) {
            return view('users.edit', ['user' => $user]);
        }
        abort(404);
    }

    public function update(UserRequest $request, $id) {   
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        return redirect()->route('users.edit', ['id' => $user->id]);
    }
}
