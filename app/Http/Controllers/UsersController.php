<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    //
    public function store($id)
    {
        \Auth::user()->users($id);
        return back();
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $data = [
            'user' => $user
        ];
        return view('users.edit', $data);
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
