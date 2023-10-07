<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\User;
use App\Post;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'posts' => $posts,
        ];
        $data += $this->userCounts($user);
    
        return view('users.show', $data);
    }

    public function edit($id)
    {
        if ($id == Auth::id()) {
            $data = [
                'user' => Auth::user()->id,
            ];
            return view('users.edit', $data);
        } else {
            abort(403); // アクセス権無し
        }
    }

    public function update(UserRequest $request, $id)
    {
        if ($id == Auth::id()) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route('users.show', $user->id);
        }
    }
}