<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() !== $user->id) {
            return back();
        }

        return view('users.edit',[
            'user' => $user  
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->save();
        return redirect()->route('user.show',$id);
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'posts' => $posts,
            'users' => collect([]),
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }

    public function followings($id)
    {
        $user = User::findOrFail($id);
        $users = $user->follows()->paginate(10);
        $data = [
            'user' => $user,
            'users' => $users,
            'posts' => collect([]),
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followed()->paginate(10);
        $data = [
            'user' => $user,
            'users' => $users,
            'posts' => collect([]),
        ];
        $data += $this->userCounts($user);
        return view('users.show', $data);
    }
}
