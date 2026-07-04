<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $posts = $user->posts()
            ->orderBy('id', 'desc')
            ->paginate(10);

        $data = [
            'user' => $user,
            'posts' => $posts,
        ];

        return view('users.show', $data);
    }

    public function edit($id)
    {
        $user = \Auth::user();
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
        $user->password = bcrypt($request->password);
        $user->save();
        return back();
    }
}
