<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit($id)
    {
        if ($id == Auth::id()) {
            $user = User::findOrFail($id);
            return view('users.edit', [
                'user' => $user,
            ]);
        }
        abort(404);
    }

    public function update(UserRequest $request, $id)
    {
        if ($id == Auth::id()) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $successMessage = "ユーザー情報を変更しました。";

            return view('users.edit', [
                'user' => $user,
                'successMessage' => $successMessage,
            ]);
        }
        abort(404);
    }

    public function destroy($id)
    {
        if ($id == Auth::id()) {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('/');
        }
        abort(404);
    }

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
    

}