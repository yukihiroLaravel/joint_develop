<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class EditUserController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit',['user' => $user]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = \Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return view('welcome');
    }
}
