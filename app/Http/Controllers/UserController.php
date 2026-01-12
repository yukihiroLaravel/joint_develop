<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;

class UserController extends Controller
{

    public function edit($id) {

        $user = User::findOrFail($id);
        return view('user.edit',['user' =>$user]);
    }


    public function update(UserRequest $request) {
        if (!empty($request->id)) {
            $user = User::find($request->id);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('welcome');
    }
}
