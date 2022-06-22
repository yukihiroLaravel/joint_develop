<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->orderBy('id', 'desc')->paginate(10);

        return view('users.show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === \Auth::id()) {
            return view('users.edit', [
                'user' => $user,
            ]);
        }
        abort(404);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/users/'. $user->id);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (\Auth::id() === $user->id) {
            $user->delete();
        }

        return redirect('/');
    }
}
