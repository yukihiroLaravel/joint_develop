<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
       //
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $data=[
            'user' => $user,
        ];
        return view('users.show',$data);   
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

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
        $user->password = Hash::make($request->password);
        $user->save();

        $data=[
            'user' => $user,
        ];
        return view('users.edit', $data);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        } else {
            
            return back();
        }
        return back();
    }    
}
