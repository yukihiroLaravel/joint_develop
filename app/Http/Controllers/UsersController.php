<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if(\Auth::id() == $user->id) {
            return view('users.edit', ['user' => $user,]);
        } else{
            abort(404);
        }
    }   

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.edit', $user->id)->with('successMessage', 'ユーザー情報を更新しました。');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if(\Auth::id() === $user->id) {
            $user->delete();
        }
        return redirect()->route('posts.index')->with('alertMessage', '退会が完了しました');
    }
}
