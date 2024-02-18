<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $name = \Auth::user()->name;
        $email = \Auth::user()->email;
        $data = [
            'user' =>$user,
            'name' => $name,
            'email' => $email,
        ];
        return view('users.edit', $data);

    }
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return back();
    }
}
