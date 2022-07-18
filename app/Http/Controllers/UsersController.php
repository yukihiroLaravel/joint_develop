<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditRequest;
class UsersController extends Controller
{
    public function edit($id)
    {
        // $user = \Auth::user,
        $user = User::findOrFail($id);
        $data=[
            'user' => $user,
            'email' => $user->email,
            'password' => $user->password,
            'confirmPassword' => $user->confirmPassword,
        ];
        return view('users.edit', $data);
    }
    public function update(EditRequest $request, $id)
    {
        
        $user = User::findOrFail($id);
        $user->save();
        // dd($request);
        return back();
    }
    public function destroy($id) 
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->user_id) {
            $user->delete();
        }
        return back();
    }
}
