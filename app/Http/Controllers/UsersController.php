<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest; 

class UsersController extends Controller
{
   public function index()
   {
       return view('welcome');
   }  


   public function edit($id)
{
    $user = \Auth::user();
    $email = $user->email;
    $data=[
        'user' => $user,
        'email' => $email,        
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