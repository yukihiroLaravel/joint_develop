<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function edit($id)
    {
        $user = \Auth::user();

        if ($user->id != $id) {
            abort(404);
        }

        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        if (Auth::user()->id != $id) {
            abort(404);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return back();
        //return view('user.show', compact('user'));  //### ユーザ詳細が作成され次第、こちらに変更予定
    }
    
    public function destroy($id)
    {
        if($id == Auth::id()) {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('/');
        }
    }
}