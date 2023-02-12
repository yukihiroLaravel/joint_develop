<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{   

    public function edit($id)
    {   
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            return view('users.edit', [
                'user' => $user,
            ]);
        }
        return App::abort(404);
    }

    protected function store(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect("/");
        }
        return App::abort(404);
    }
}
