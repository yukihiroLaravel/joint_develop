<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function edit($id) {

        $user = \Auth::user();
        if (\Auth::check() && \Auth::id() == $id) {
            return view('users.edit', ['user' => $user]);
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
        return view('users.show', $data);
    }

    public function update(UserRequest $request, $id) {   
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();
        return redirect()->route('users.edit', ['id' => $user->id])->with('updateSuccessMessage', '登録情報を更新しました');
    }

    public function followingUsers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followings()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'users' => $users,
        ];
        return view('users.show', $data);
    }

    public function followers($id)
    {
        $user = User::findOrFail($id);
        $users = $user->followers()->orderBy('id', 'desc')->paginate(10);
        $data = [
            'user' => $user,
            'users' => $users,
        ];
        return view('users.show', $data);
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/')->with('destroyMessage', '退会処理をしました');
    }
}
