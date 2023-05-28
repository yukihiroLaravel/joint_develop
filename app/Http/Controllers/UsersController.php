<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserRequest;


class UsersController extends Controller
{
    public function show()
    {
        return view('users.show');
    }

    public function edit($id)
    {
        $id == \Auth::id();
        $user = \Auth::user();
        $data=[
            'user' => $user,
        ];
        return view('users.edit', $data);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('/');
    }
}
