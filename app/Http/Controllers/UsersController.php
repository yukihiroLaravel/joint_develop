<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            return view("users.edit",["user" => $user]);
        }
        else {
            return back();
        }
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (\Auth::id() === $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return back();
    }

    public function destroy($id)
    {
        $user = \Auth::user();
+       $user->delete();
        return back();
    }

}
