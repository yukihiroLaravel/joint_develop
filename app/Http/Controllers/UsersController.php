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

    public function edit($id)
    {
        // $user = \Auth::user();
        $user = User::find(1);
        return view("users.edit",["user" => $user]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return back();
    }

}
