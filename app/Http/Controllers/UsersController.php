<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Http\Request\UsersRequest;

class UsersController extends Controller
{
    public function edit($id)
    {
        $user = \Auth::user();
        if ($id == $user->id) {
        $data = [
            'user' => $user,
        ];
        return view('users.edit', $data);
        } else {
        return redirect('/');
        }
    }

    public function update(UsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); 
        $user->save();
        return back();
    }

    public function show(){
        dd("aa");
    }
}    

