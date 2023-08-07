<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Request\UsersRequest;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $data=[
            'user' => $user,
        ];
        return view('users.edit', $data);
    }

    public function update(UsersRequest $request, $id)
    {
        $user = user::findOrFail($id);
        $user->name = $repuest->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); 
        $user->save();
        return back();
    }
}    