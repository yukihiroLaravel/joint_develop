<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function edit ($id)
    {
       $user = \Auth::user();
       $user = User::findOrFail($id);
       $data = [
        'user' =>$user,
       ];
       return view('users.edit', $data);
    }


    public function update (Request $request ,$id)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $user = user::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return back();
    }
}