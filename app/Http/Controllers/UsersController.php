<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id','desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        return view('users.show', $data);
    }
    public function edit ($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() == $user->id) {
            return view('users.edit', ['user' => $user]);
        }

        abort(404);
    }
    public function update (Request $request ,$id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8','confirmed'],
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return back();
    }

    public function destroy ($id)
    {
        $user = User::findOrFail($id);
        $user->forceDelete();
        return redirect('/');
    }
}
