<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user'=> $user,
            'posts'=>$posts
        ];
        return view('users.show', $data);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->id !== $user->id) {
            abort(403);
        }
        return view('users.edit', ['user' => $user]);
    }
    
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); 
        $user->save();
        return redirect()->route('user.show',['id'=> $user->id]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::user()->id === $user->id) {
            $user->delete();
        }
        return redirect('/');
    }
}
