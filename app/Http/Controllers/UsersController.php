<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
<<<<<<< HEAD
use App\Post;

class UsersController extends Controller
{   
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data=[
            'user' => $user,
            'posts' => $posts,

         ];
            return view('users.show',$data);
    }
    
=======
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function edit($id)
    {
        if ($id == \Auth::id()) {
            $user = \Auth::user();
            return view('users.edit',['user'=>$user]);
        }
        abort(404);
    }
    
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() == $user->id) {
            $user->delete();
        }
        return back();
    }
>>>>>>> develop_c_mutsuki_dra
}
