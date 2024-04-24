<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;


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
        // $user = \Auth::user();
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
        $user->password = $request->password;
        $user->save();
        return back();
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
